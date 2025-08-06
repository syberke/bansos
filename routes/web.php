<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\LoginController;
Route::get('/', [PenerimaController::class, 'index'])->name('penerima.index');
Route::get('/penerima/create', [PenerimaController::class, 'create'])->name('penerima.create');
Route::post('/penerima', [PenerimaController::class, 'store'])->name('penerima.store');
Route::get('/penerima/{penerima}/edit', [PenerimaController::class, 'edit'])->name('penerima.edit');
Route::put('/penerima/{penerima}', [PenerimaController::class, 'update'])->name('penerima.update');
Route::get('/penerima/export/{kode}', [PenerimaController::class, 'exportBarcode'])->name('penerima.export');
Route::get('/qrcode/{text}', [QRCodeController::class, 'generate']);
Route::get('/penerima/export/all', [PenerimaController::class, 'exportAllBarcode'])->name('penerima.exportAllBarcode');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
