<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

Route::get('/', [BillController::class, 'index'])->name('home');

Route::post('/upload', [BillController::class, 'upload'])->name('upload');