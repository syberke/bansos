<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\QRCodeController;
Route::get('/', [PenerimaController::class, 'index'])->name('penerima.index');
Route::get('/penerima/create', [PenerimaController::class, 'create'])->name('penerima.create');
Route::post('/penerima', [PenerimaController::class, 'store'])->name('penerima.store');
Route::get('/penerima/{penerima}/edit', [PenerimaController::class, 'edit'])->name('penerima.edit');
Route::put('/penerima/{penerima}', [PenerimaController::class, 'update'])->name('penerima.update');
Route::get('/penerima/{penerima}/barcode', [PenerimaController::class, 'exportBarcode'])->name('penerima.barcode');
Route::get('/qrcode/{text}', [QRCodeController::class, 'generate']);
