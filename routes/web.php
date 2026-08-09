<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ShopeeController;
use App\Http\Controllers\PdfMergeController;

/*
|--------------------------------------------------------------------------
| Trang chủ
|--------------------------------------------------------------------------
*/

Route::get('/', [BillController::class, 'index'])
    ->name('home');


/*
|--------------------------------------------------------------------------
| TIKTOK
|--------------------------------------------------------------------------
*/

Route::post('/tiktok/upload', [BillController::class, 'upload'])
    ->name('upload');

Route::get('/tiktok/download', [BillController::class, 'download'])
    ->name('tiktok.download');


/*
|--------------------------------------------------------------------------
| SHOPEE
|--------------------------------------------------------------------------
*/

Route::get('/shopee', [ShopeeController::class, 'index'])
    ->name('shopee');

Route::post('/shopee-upload', [ShopeeController::class, 'upload'])
    ->name('shopee.upload');

Route::get('/shopee-download', [ShopeeController::class, 'download'])
    ->name('shopee.download');


/*
|--------------------------------------------------------------------------
| GHÉP PDF
|--------------------------------------------------------------------------
*/

Route::get('/pdf-merge', [PdfMergeController::class, 'index'])
    ->name('pdf.merge');

Route::post('/pdf-merge', [PdfMergeController::class, 'merge'])
    ->name('pdf.merge.process');