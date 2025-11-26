<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\CartController;
use App\Http\Controllers\Shared\StokController;

Route::middleware(['auth', 'role:Karyawan,Admin'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Karyawan\KaryawanController::class, 'index'])->name('dashboard');

    // Cart & Transaksi
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'addItem'])->name('add');
        Route::delete('/item/{id}', [CartController::class, 'removeItem'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    // Manajemen Stok (hanya lihat & input via pembelian)
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
    });
    Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian.index');
});