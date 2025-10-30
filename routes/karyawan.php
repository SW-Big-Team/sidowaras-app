<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\CartController;
use App\Http\Controllers\Obat\ObatController;

Route::middleware(['auth', 'role:Karyawan,Admin'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', fn() => view('karyawan.index'))->name('dashboard');

    // Cart & Transaksi
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index'); // ← ini jadi: karyawan.cart.index
        Route::post('/add', [CartController::class, 'addItem'])->name('add');
        Route::delete('/item/{id}', [CartController::class, 'removeItem'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

    // Pembelian Obat
    // (belum diisi)

    // Stock barang
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/tambah', [ObatController::class, 'createForKaryawan'])->name('tambah');
        Route::post('/tambah', [ObatController::class, 'store'])->name('store');
    });
});