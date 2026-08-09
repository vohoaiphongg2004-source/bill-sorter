<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Process;
use Spatie\PdfToText\Pdf;

class ShopeeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Trang upload
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('index');
    }


    /*
    |--------------------------------------------------------------------------
    | Upload + xử lý PDF
    |--------------------------------------------------------------------------
    */

    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|array|min:1',
            'pdf.*' => 'required|file|mimes:pdf|max:51200',
        ]);


        $files = $request->file('pdf');

        $disk = Storage::disk('local');

        $workDir = storage_path('app/pdf-sorter');


        /*
        |--------------------------------------------------------------------------
        | Tạo thư mục làm việc
        |--------------------------------------------------------------------------
        */

        if (!is_dir($workDir)) {

            mkdir(
                $workDir,
                0777,
                true
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Lưu các file upload
        |--------------------------------------------------------------------------
        */

        $inputPaths = [];


        foreach ($files as $file) {

            $filename =
                uniqid('shopee_')
                . '.pdf';


            $path = $file->storeAs(
                'pdf-sorter',
                $filename,
                'local'
            );


            $inputPaths[] =
                $disk->path($path);
        }


        /*
        |--------------------------------------------------------------------------
        | Nếu chỉ có 1 file
        |--------------------------------------------------------------------------
        */

        if (count($inputPaths) === 1) {

            $mergedPdf =
                $inputPaths[0];

        } else {

            /*
            |--------------------------------------------------------------------------
            | Nếu có nhiều file -> ghép PDF
            |--------------------------------------------------------------------------
            */

            $mergedPdf =
                $workDir
                . '/merged_'
                . uniqid()
                . '.pdf';


            $this->mergePdf(
                $inputPaths,
                $mergedPdf
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Kiểm tra file PDF
        |--------------------------------------------------------------------------
        */

        if (!file_exists($mergedPdf)) {

            throw new \Exception(
                'Không tìm thấy file PDF để xử lý: '
                . $mergedPdf
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Đọc PDF bằng pdftotext
        |--------------------------------------------------------------------------
        */

        $text = Pdf::getText(
            $mergedPdf,
            $this->getPdftotextPath()
        );


        if (empty(trim($text))) {

            throw new \Exception(
                'Không đọc được nội dung PDF. '
                . 'Hãy kiểm tra PDF có chứa text hay không.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tách từng trang
        |--------------------------------------------------------------------------
        */

        $pages = preg_split(
            '/\f/',
            $text
        );


        $bills = [];


        /*
        |--------------------------------------------------------------------------
        | Đọc từng bill
        |--------------------------------------------------------------------------
        */

        foreach ($pages as $index => $page) {

            if (trim($page) === '') {

                continue;
            }


            $info =
                $this->extractProduct($page);


            /*
            |--------------------------------------------------------------------------
            | Không đọc được sản phẩm thì bỏ qua
            |--------------------------------------------------------------------------
            */

            if ($info['product'] === '') {

                continue;
            }


            $bills[] = [

                'page' =>
                    $index + 1,

                'product' =>
                    $info['product'],

                'qty' =>
                    $info['qty'],

                'multi' =>
                    $info['multi'],
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Không tìm thấy bill
        |--------------------------------------------------------------------------
        */

        if (empty($bills)) {

            throw new \Exception(
                'Không tìm thấy sản phẩm trong PDF. '
                . 'Số trang đọc được: '
                . count($pages)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Sắp xếp
        |
        | Bill nhiều sản phẩm lên đầu
        | Sau đó sắp xếp theo tên sản phẩm
        |--------------------------------------------------------------------------
        */

        $sorted = collect($bills)
            ->sort(function ($a, $b) {

                /*
                | Bill nhiều sản phẩm lên đầu
                */

                if (
                    $a['multi']
                    !==
                    $b['multi']
                ) {

                    return $a['multi']
                        ? -1
                        : 1;
                }


                /*
                | Cùng loại -> sort tên
                */

                return strnatcasecmp(
                    $a['product'],
                    $b['product']
                );
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Danh sách trang
        |--------------------------------------------------------------------------
        */

        $pageList =
            $sorted
                ->pluck('page')
                ->implode(',');


        /*
        |--------------------------------------------------------------------------
        | Tạo tên file PDF kết quả
        |--------------------------------------------------------------------------
        */

        $filename =
            'shopee_sorted_'
            . date('Ymd_His')
            . '_'
            . uniqid()
            . '.pdf';


        $sortedPdf =
            $workDir
            . '/'
            . $filename;


        /*
        |--------------------------------------------------------------------------
        | Tạo PDF đã sắp xếp
        |--------------------------------------------------------------------------
        */

        $this->createSortedPdf(
            $mergedPdf,
            $sorted
                ->pluck('page')
                ->toArray(),
            $sortedPdf
        );


        /*
        |--------------------------------------------------------------------------
        | Lưu file vào session
        |--------------------------------------------------------------------------
        */

        session([

            'shopee_sorted_pdf' =>
                $sortedPdf,

            'shopee_sorted_filename' =>
                $filename,

        ]);


        /*
        |--------------------------------------------------------------------------
        | Nhóm bill sản phẩm đơn
        |--------------------------------------------------------------------------
        */

        $single =
            $sorted->where(
                'multi',
                false
            );


        $groups =
            $single
                ->groupBy('product')
                ->map(function ($items) {

                    return [

                        'count' =>
                            $items->count(),

                        'pages' =>
                            $items
                                ->pluck('page')
                                ->implode(','),

                    ];
                });


        /*
        |--------------------------------------------------------------------------
        | Bill nhiều sản phẩm
        |--------------------------------------------------------------------------
        */

        $multiPages =
            $sorted
                ->where(
                    'multi',
                    true
                )
                ->pluck('page')
                ->implode(',');


        /*
        |--------------------------------------------------------------------------
        | Hiển thị kết quả
        |--------------------------------------------------------------------------
        */

        return view(
            'shopeeresult',
            compact(
                'groups',
                'pageList',
                'multiPages'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GHÉP PDF
    |
    | Dùng pdfunite
    |--------------------------------------------------------------------------
    */

    private function mergePdf(
        array $inputPaths,
        string $outputPath
    ) {

        $pdfunite =
            $this->getPdfunitePath();


        /*
        |--------------------------------------------------------------------------
        | Kiểm tra pdfunite
        |--------------------------------------------------------------------------
        */

        if (!file_exists($pdfunite)) {

            throw new \Exception(
                'Không tìm thấy pdfunite tại: '
                . $pdfunite
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tạo command
        |--------------------------------------------------------------------------
        */

        $command = [
            $pdfunite
        ];


        /*
        |--------------------------------------------------------------------------
        | Thêm các file PDF
        |--------------------------------------------------------------------------
        */

        foreach ($inputPaths as $path) {

            $command[] =
                $path;
        }


        /*
        |--------------------------------------------------------------------------
        | File output
        |--------------------------------------------------------------------------
        */

        $command[] =
            $outputPath;


        /*
        |--------------------------------------------------------------------------
        | Chạy pdfunite
        |--------------------------------------------------------------------------
        */

        $result =
            Process::timeout(300)
                ->run($command);


        /*
        |--------------------------------------------------------------------------
        | Kiểm tra lỗi
        |--------------------------------------------------------------------------
        */

        if ($result->failed()) {

            throw new \Exception(

                "Không thể ghép PDF.\n\n"

                . "pdfunite error:\n"
                . $result->errorOutput()

                . "\n\nOutput:\n"
                . $result->output()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Kiểm tra file
        |--------------------------------------------------------------------------
        */

        if (!file_exists($outputPath)) {

            throw new \Exception(
                'File PDF sau khi ghép không tồn tại.'
            );
        }


        if (filesize($outputPath) <= 0) {

            throw new \Exception(
                'File PDF sau khi ghép có dung lượng bằng 0.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | TẠO PDF THEO THỨ TỰ
    |
    | Dùng qpdf
    |--------------------------------------------------------------------------
    */

    private function createSortedPdf(
    string $inputPdf,
    array $pages,
    string $outputPdf
) {
    /*
    |--------------------------------------------------------------------------
    | QPDF
    |--------------------------------------------------------------------------
    */

    if (PHP_OS_FAMILY === 'Windows') {

        $qpdf =
            'C:\Program Files\qpdf 12.3.2\bin\qpdf.exe';

    } else {

        $qpdf =
            '/usr/bin/qpdf';
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra QPDF
    |--------------------------------------------------------------------------
    */

    if (!file_exists($qpdf)) {

        throw new \Exception(
            'Không tìm thấy QPDF tại: ' . $qpdf
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra input
    |--------------------------------------------------------------------------
    */

    if (!file_exists($inputPdf)) {

        throw new \Exception(
            'Không tìm thấy PDF gốc: ' . $inputPdf
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra pages
    |--------------------------------------------------------------------------
    */

    if (empty($pages)) {

        throw new \Exception(
            'Không có trang nào để sắp xếp.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | File PDF repair
    |--------------------------------------------------------------------------
    */

    $repairedPdf =
        dirname($outputPdf)
        . DIRECTORY_SEPARATOR
        . 'repaired_'
        . uniqid()
        . '.pdf';


    /*
    |--------------------------------------------------------------------------
    | BƯỚC 1
    |
    | Repair / normalize PDF
    |--------------------------------------------------------------------------
    */

    $repairResult =
        Process::timeout(300)
            ->run([
                $qpdf,

                '--warning-exit-0',

                $inputPdf,

                $repairedPdf,
            ]);


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra file repair
    |--------------------------------------------------------------------------
    */

    if (
        !file_exists($repairedPdf) ||
        filesize($repairedPdf) <= 0
    ) {

        throw new \Exception(

            "Không thể repair PDF.\n\n"

            . "Input:\n"
            . $inputPdf

            . "\n\nQPDF error:\n"
            . $repairResult->errorOutput()

            . "\n\nQPDF output:\n"
            . $repairResult->output()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BƯỚC 2
    |
    | Lấy tổng số trang
    |--------------------------------------------------------------------------
    */

    $countResult =
        Process::timeout(300)
            ->run([
                $qpdf,

                '--warning-exit-0',

                '--show-npages',

                $repairedPdf,
            ]);


    $countOutput =
        trim(
            $countResult->output()
        );


    /*
    |--------------------------------------------------------------------------
    | Parse số trang
    |--------------------------------------------------------------------------
    */

    if (
        !preg_match(
            '/^\s*(\d+)\s*$/m',
            $countOutput,
            $match
        )
    ) {

        throw new \Exception(

            "Không thể đọc số trang PDF sau khi repair.\n\n"

            . "QPDF error:\n"
            . $countResult->errorOutput()

            . "\n\nQPDF output:\n"
            . $countResult->output()
        );
    }


    $totalPages =
        (int) $match[1];


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra tổng trang
    |--------------------------------------------------------------------------
    */

    if ($totalPages <= 0) {

        throw new \Exception(
            'QPDF không xác định được số trang PDF.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Lọc page hợp lệ
    |--------------------------------------------------------------------------
    */

    $validPages = [];


    foreach ($pages as $page) {

        $page =
            (int) $page;


        if (
            $page >= 1 &&
            $page <= $totalPages
        ) {

            $validPages[] =
                $page;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa duplicate
    |--------------------------------------------------------------------------
    */

    $validPages =
        array_values(
            array_unique(
                $validPages
            )
        );


    /*
    |--------------------------------------------------------------------------
    | Không có page
    |--------------------------------------------------------------------------
    */

    if (empty($validPages)) {

        if (file_exists($repairedPdf)) {
            @unlink($repairedPdf);
        }

        throw new \Exception(
            "Không có trang hợp lệ.\n"
            . "PDF có {$totalPages} trang."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Page specification
    |
    | Ví dụ:
    |
    | 44,12,4,20,27,9...
    |--------------------------------------------------------------------------
    */

    $pageSpec =
        implode(
            ',',
            $validPages
        );


    /*
    |--------------------------------------------------------------------------
    | BƯỚC 3
    |
    | QPDF 12.x:
    |
    | --file
    | --range
    |
    | Cách này tránh QPDF hiểu nhầm page number
    | thành tên file.
    |--------------------------------------------------------------------------
    */

    $command = [

        $qpdf,

        '--warning-exit-0',

        '--empty',

        '--pages',

        '--file=' . $repairedPdf,

        '--range=' . $pageSpec,

        '--',

        $outputPdf,
    ];


    /*
    |--------------------------------------------------------------------------
    | Chạy QPDF
    |--------------------------------------------------------------------------
    */

    $result =
        Process::timeout(300)
            ->run($command);


    /*
    |--------------------------------------------------------------------------
    | Nếu không tạo output
    |--------------------------------------------------------------------------
    */

    if (
        !file_exists($outputPdf) ||
        filesize($outputPdf) <= 0
    ) {

        if (file_exists($repairedPdf)) {
            @unlink($repairedPdf);
        }


        throw new \Exception(

            "Không thể tạo PDF đã sắp xếp.\n\n"

            . "Input:\n"
            . $inputPdf

            . "\n\nOutput:\n"
            . $outputPdf

            . "\n\nTổng số trang: "
            . $totalPages

            . "\n\nTrang yêu cầu:\n"
            . implode(
                ',',
                $pages
            )

            . "\n\nTrang hợp lệ:\n"
            . implode(
                ',',
                $validPages
            )

            . "\n\nQPDF error:\n"
            . $result->errorOutput()

            . "\n\nQPDF output:\n"
            . $result->output()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa file repair
    |--------------------------------------------------------------------------
    */

    if (
        file_exists($repairedPdf)
    ) {

        @unlink(
            $repairedPdf
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra output cuối
    |--------------------------------------------------------------------------
    */

    if (
        !file_exists($outputPdf)
    ) {

        throw new \Exception(
            'QPDF không tạo được file output.'
        );
    }


    if (
        filesize($outputPdf) <= 0
    ) {

        throw new \Exception(
            'File PDF kết quả có dung lượng bằng 0.'
        );
    }
}

    private function getPdftotextPath()
    {
        if (
            PHP_OS_FAMILY === 'Windows'
        ) {

            return
                'C:\poppler-26.02.0\Library\bin\pdftotext.exe';
        }


        return
            '/usr/bin/pdftotext';
    }


    /*
    |--------------------------------------------------------------------------
    | Đường dẫn pdfunite
    |--------------------------------------------------------------------------
    */

    private function getPdfunitePath()
    {
        if (
            PHP_OS_FAMILY === 'Windows'
        ) {

            return
                'C:\poppler-26.02.0\Library\bin\pdfunite.exe';
        }


        return
            '/usr/bin/pdfunite';
    }


    /*
    |--------------------------------------------------------------------------
    | TÁCH THÔNG TIN SẢN PHẨM
    |--------------------------------------------------------------------------
    */

    private function extractProduct($text)
    {

        $result = [

            'product' => '',

            'qty' => 1,

            'multi' => false,

        ];


        /*
        |--------------------------------------------------------------------------
        | Chuẩn hóa text
        |--------------------------------------------------------------------------
        */

        $text =
            preg_replace(
                '/\r\n|\r|\n/u',
                ' ',
                $text
            );


        $text =
            preg_replace(
                '/\s+/u',
                ' ',
                $text
            );


        $text =
            trim($text);


        /*
        |--------------------------------------------------------------------------
        | Tìm Nội dung hàng
        |--------------------------------------------------------------------------
        */

        $contentPos =
            mb_stripos(
                $text,
                'Nội dung hàng'
            );


        if (
            $contentPos !== false
        ) {

            $text =
                mb_substr(
                    $text,
                    $contentPos
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Cắt trước Ngày đặt hàng
        |--------------------------------------------------------------------------
        */

        $datePos =
            mb_stripos(
                $text,
                'Ngày đặt hàng'
            );


        if (
            $datePos !== false
        ) {

            $text =
                mb_substr(
                    $text,
                    0,
                    $datePos
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Xác định bill nhiều sản phẩm
        |
        | Ví dụ:
        |
        | 1. Sản phẩm A SL: 1
        | 2. Sản phẩm B SL: 1
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/1\.\s+.*?SL\s*:\s*\d+.*?2\.\s+/isu',
                $text
            )
        ) {

            $result['multi'] =
                true;
        }


        /*
        |--------------------------------------------------------------------------
        | Lấy sản phẩm số 1
        |--------------------------------------------------------------------------
        */

        if (
            preg_match(
                '/(?:^|\s)1\.\s*(.*?)\s*SL\s*:\s*(\d+)/isu',
                $text,
                $matches
            )
        ) {

            $product =
                trim(
                    $matches[1]
                );


            /*
            |--------------------------------------------------------------------------
            | Bỏ [ Giá Sỉ ]
            |--------------------------------------------------------------------------
            */

            $product =
                preg_replace(
                    '/\[\s*Giá\s*Sỉ\s*\]/iu',
                    '',
                    $product
                );


            /*
            |--------------------------------------------------------------------------
            | Chuẩn hóa khoảng trắng
            |--------------------------------------------------------------------------
            */

            $product =
                preg_replace(
                    '/\s+/u',
                    ' ',
                    $product
                );


            $product =
                trim($product);


            /*
            |--------------------------------------------------------------------------
            | Nếu tên có dấu phẩy
            |
            | Lấy phần cuối
            |--------------------------------------------------------------------------
            */

            if (
                str_contains(
                    $product,
                    ','
                )
            ) {

                $parts =
                    explode(
                        ',',
                        $product
                    );


                $lastPart =
                    trim(
                        end($parts)
                    );


                if (
                    $lastPart !== ''
                ) {

                    $product =
                        $lastPart;
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Lưu kết quả
            |--------------------------------------------------------------------------
            */

            $result['product'] =
                $product;


            $result['qty'] =
                (int) $matches[2];
        }


        return $result;
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF ĐÃ SẮP XẾP
    |--------------------------------------------------------------------------
    */

    public function download()
{
    $file = session('shopee_sorted_pdf');

    $filename = session(
        'shopee_sorted_filename',
        'bill_shopee_da_sap_xep.pdf'
    );

    /*
    |--------------------------------------------------------------------------
    | Kiểm tra file
    |--------------------------------------------------------------------------
    */

    if (!$file || !file_exists($file)) {

        abort(
            404,
            'Không tìm thấy file PDF Shopee đã sắp xếp.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Download PDF
    |--------------------------------------------------------------------------
    */

    return response()->download($file,$filename)
    ->deleteFileAfterSend(true);
}
}