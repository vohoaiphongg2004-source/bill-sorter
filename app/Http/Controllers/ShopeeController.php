<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class ShopeeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        // Validate file
        $request->validate([
            'pdf' => 'required|mimes:pdf'
        ]);

        // Lưu PDF
        $path = $request->file('pdf')->store('pdf', 'local');

        // Đường dẫn đầy đủ
        $fullPath = Storage::disk('local')->path($path);

        /*
    |--------------------------------------------------------------------------
    | Đọc PDF bằng pdftotext
    |--------------------------------------------------------------------------
    */

        $pdftotext = PHP_OS_FAMILY === 'Windows'
            ? 'C:\poppler-26.02.0\Library\bin\pdftotext.exe'
            : '/usr/bin/pdftotext';

        $text = Pdf::getText(
            $fullPath,
            $pdftotext
        );

        /*
    |--------------------------------------------------------------------------
    | Tách từng trang
    |--------------------------------------------------------------------------
    */

        $pages = preg_split('/\f/', $text);

        $bills = [];

        /*
    |--------------------------------------------------------------------------
    | Đọc từng bill
    |--------------------------------------------------------------------------
    */

        foreach ($pages as $index => $page) {

            // Bỏ trang trống
            if (trim($page) === '') {
                continue;
            }

            // Lấy thông tin sản phẩm
            $info = $this->extractProduct($page);

            // Không lấy những trang không đọc được sản phẩm
            if (empty($info['product'])) {
                continue;
            }

            $bills[] = [
                'page'    => $index + 1,
                'product' => $info['product'],
                'qty'     => $info['qty'],
                'multi'   => $info['multi'],
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | BILL NHIỀU SẢN PHẨM
    |
    | Đưa lên đầu.
    |
    | Giữ nguyên thứ tự trang PDF.
    |--------------------------------------------------------------------------
    */

        $multi = collect($bills)
            ->filter(function ($bill) {
                return $bill['multi'] === true;
            })
            ->sortBy('page')
            ->values();

        /*
    |--------------------------------------------------------------------------
    | BILL 1 SẢN PHẨM
    |
    | Sắp xếp theo tên sản phẩm.
    |--------------------------------------------------------------------------
    */

        $single = collect($bills)
            ->filter(function ($bill) {
                return $bill['multi'] === false;
            })
            ->sortBy(function ($bill) {
                return mb_strtolower(
                    trim($bill['product']),
                    'UTF-8'
                );
            })
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Gộp:
    |
    | 1. Bill nhiều sản phẩm
    | 2. Bill một sản phẩm đã sort theo tên
    |--------------------------------------------------------------------------
    */

        $sorted = $multi
            ->concat($single)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Chỉ lấy số trang cần in
    |--------------------------------------------------------------------------
    */

        $pagesToPrint = $sorted
            ->pluck('page')
            ->implode(',');

        /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Tạm thời dùng dd() để kiểm tra.
    |
    */



        /*
    |--------------------------------------------------------------------------
    | Nếu không cần debug thì bỏ dd() ở trên
    |--------------------------------------------------------------------------
    */

        return view('shopeeresult', compact(
            'pagesToPrint'
        ));
    }
    private function extractProduct($text)
    {
        $result = [
            'product' => '',
            'qty'     => 1,
            'multi'   => false,
        ];

        // Chuẩn hóa xuống dòng
        $text = str_replace(
            ["\r\n", "\r"],
            "\n",
            $text
        );

        /*
    |--------------------------------------------------------------------------
    | Tìm các sản phẩm:
    |
    | 1. Tên sản phẩm, SL: 1
    | 2. Tên sản phẩm, SL: 2
    |--------------------------------------------------------------------------
    */

        preg_match_all(
            '/^\s*(\d+)\.\s*(.*?)\s*,\s*SL\s*:\s*(\d+)/msu',
            $text,
            $matches,
            PREG_SET_ORDER
        );

        /*
    |--------------------------------------------------------------------------
    | Xác định bill nhiều sản phẩm
    |--------------------------------------------------------------------------
    */

        $totalItems = count($matches);

        $result['multi'] = $totalItems > 1;

        /*
    |--------------------------------------------------------------------------
    | Không tìm thấy sản phẩm
    |--------------------------------------------------------------------------
    */

        if ($totalItems === 0) {
            return $result;
        }

        /*
    |--------------------------------------------------------------------------
    | Lấy sản phẩm đầu tiên
    |--------------------------------------------------------------------------
    */

        $product = trim($matches[0][2]);

        $qty = (int) $matches[0][3];

        /*
    |--------------------------------------------------------------------------
    | Bỏ [ Giá Sỉ ]
    |--------------------------------------------------------------------------
    */

        $product = preg_replace(
            '/^\[\s*Giá\s*Sỉ\s*\]\s*/ui',
            '',
            $product
        );

        /*
    |--------------------------------------------------------------------------
    | Chuẩn hóa Unicode
    |--------------------------------------------------------------------------
    */

        if (class_exists('\Normalizer')) {

            $product = \Normalizer::normalize(
                $product,
                \Normalizer::FORM_KC
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Chuẩn hóa khoảng trắng
    |--------------------------------------------------------------------------
    */

        $product = preg_replace(
            '/\s+/u',
            ' ',
            $product
        );

        $product = trim($product);

        /*
    |--------------------------------------------------------------------------
    | Kết quả
    |--------------------------------------------------------------------------
    */

        $result['product'] = $product;
        $result['qty'] = $qty;

        return $result;
    }
}
