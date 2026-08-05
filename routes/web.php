<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::get('/', [BillController::class, 'index']);
Route::post('/upload', [BillController::class, 'upload'])->name('upload');
Route::get('/', function () {
    return view('index');
});
