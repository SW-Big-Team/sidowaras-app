<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\CartController;
<<<<<<< HEAD
use App\Http\Controllers\Shared\StokController;
=======
use App\Http\Controllers\Obat\ObatController;
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)

Route::middleware(['auth', 'role:Karyawan,Admin'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', fn() => view('karyawan.index'))->name('dashboard');

    // Cart & Transaksi
    Route::prefix('cart')->name('cart.')->group(function () {
<<<<<<< HEAD
        Route::get('/', [CartController::class, 'index'])->name('index');
=======
        Route::get('/', [CartController::class, 'index'])->name('index'); // ← ini jadi: karyawan.cart.index
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
        Route::post('/add', [CartController::class, 'addItem'])->name('add');
        Route::delete('/item/{id}', [CartController::class, 'removeItem'])->name('remove');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });

<<<<<<< HEAD
    // Manajemen Stok (hanya lihat & input via pembelian)
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
    });
    Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian.index');
=======
    // Pembelian Obat
    // (belum diisi)

    // Stock barang
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/tambah', [ObatController::class, 'createForKaryawan'])->name('tambah');
        Route::post('/tambah', [ObatController::class, 'store'])->name('store');
    });
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
});