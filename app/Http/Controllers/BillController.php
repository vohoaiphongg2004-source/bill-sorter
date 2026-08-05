<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use setasign\Fpdi\Fpdi;
class BillController extends Controller
{
    public function index()
    {
        return view('index');
    }



private function compareSku($skuA, $skuB)
{
    // Lấy số đầu chuỗi nếu có
    preg_match('/^\d+/', $skuA, $matchA);
    preg_match('/^\d+/', $skuB, $matchB);

    $numA = isset($matchA[0]) ? (int)$matchA[0] : null;
    $numB = isset($matchB[0]) ? (int)$matchB[0] : null;

    // Cả hai đều bắt đầu bằng số
    if ($numA !== null && $numB !== null) {
        if ($numA != $numB) {
            return $numA <=> $numB;
        }
    }

    // Nếu một cái có số đầu, một cái không
    if ($numA !== null && $numB === null) {
        return -1;
    }

    if ($numA === null && $numB !== null) {
        return 1;
    }

    // So sánh chữ
    return strnatcasecmp($skuA, $skuB);
}
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|mimes:pdf'
        ]);

        // Upload file
        $path = $request->file('pdf')->store('pdf', 'local');
        $fullPath = Storage::disk('local')->path($path);

        // Đọc PDF
        $parser = new Parser();
        $pdf = $parser->parseFile($fullPath);
        $pages = $pdf->getPages();

        $bills = [];

        foreach ($pages as $index => $page) {

            $text = $page->getText();

            $info = $this->extractProduct($text);

            $bills[] = [
                'page'    => $index + 1,
                'product' => $info['product'],
                'sku'     => $info['sku'],
                'qty'     => $info['qty'],
                'multi'   => $info['multi'],
            ];
        }
$sorted = collect($bills)
    ->sort(function ($a, $b) {

        // 1. Product
        $compareProduct = strnatcasecmp($a['product'], $b['product']);

        if ($compareProduct !== 0) {
            return $compareProduct;
        }

        // 2. SKU
        $compareSku = $this->compareSku($a['sku'], $b['sku']);

        if ($compareSku !== 0) {
            return $compareSku;
        }

        // 3. Qty
        return $a['qty'] <=> $b['qty'];

    })
    ->values();
    
    
        $single = [];
$multi = [];

foreach ($sorted as $bill) {

    if ($bill['multi']) {
        $multi[] = $bill;
    } else {
        $single[] = $bill;
    }
}

        $groups = collect($single)
    ->groupBy('product')
    ->map(function ($items) {

        return [
            'count' => $items->count(),
            'pages' => $items->pluck('page')->implode(','),
        ];

    });

return view('result', compact('groups'));
    }

    private function extractProduct($text)
{
    $result = [
        'product' => '',
        'sku' => '',
        'qty' => 1,
        'multi' => false,
    ];

    
    if (!preg_match('/Product Name.*?Qty(.*?)Qty Total:/is', $text, $match)) {
        return $result;
    }

    $content = trim($match[1]);

    $lines = preg_split('/\r\n|\r|\n/', $content);
    $lines = array_values(array_filter(array_map('trim', $lines)));

    $product = [];

    foreach ($lines as $line) {

        // SKU + Qty cùng dòng
        if (preg_match('/^(.*?)\s+(\d+)$/u', $line, $m)) {

            $result['sku'] = trim($m[1]);
            $result['qty'] = (int)$m[2];

            break;
        }

        // Qty nằm riêng một dòng
        if (preg_match('/^\d+$/', $line)) {

            $result['qty'] = (int)$line;

            break;
        }

        $product[] = $line;
    }

    // SKU bị đưa vào product thì bỏ ra
    if (!empty($result['sku']) && end($product) == $result['sku']) {
        array_pop($product);
    }

    $result['product'] = trim(implode(' ', $product));

    return $result;
}
}
