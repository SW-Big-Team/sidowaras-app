<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Karyawan,Admin'])->prefix('karyawan')->name('karyawan.')->group(function () {

    // Dashboard karyawan
    Route::get('/dashboard', fn() => view('karyawan.index'))->name('dashboard');

    // Keranjang
    Route::get('/keranjang', fn() => view('karyawan.cart.index'))->name('keranjang');

    // Pembelian Obat


    // Stock barang
    Route::get('/stock', fn() => view('karyawan.inventory.index'))->name('stock.index');
    Route::get('/stock/tambah', fn() => view('karyawan.inventory.tambah'))->name('stock.tambah');
});
