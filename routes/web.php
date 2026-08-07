<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ShopeeController;
use App\Http\Controllers\PdfMergeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', [BillController::class, 'index'])->name('home');
Route::get('/pdf-merge', [PdfMergeController::class, 'index'])
    ->name('pdf.merge');

Route::post('/pdf-merge', [PdfMergeController::class, 'merge'])
    ->name('pdf.merge.process');
Route::post('/upload', [BillController::class, 'upload'])->name('upload');
Route::post('/shopee-upload', [ShopeeController::class, 'upload'])
    ->name('shopee.upload');