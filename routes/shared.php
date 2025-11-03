<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\Shared\StokController;
use App\Http\Controllers\Shared\StokOpnameController;

Route::middleware(['auth', 'role:Admin,Karyawan,Kasir'])->prefix('shared')->group(function () {
    // Pembelian Obat (semua role)
    Route::prefix('pembelian')->name('pembelian.')->group(function () {
        Route::get('/', [PembelianController::class, 'index'])->name('index');
        Route::get('/create', [PembelianController::class, 'create'])->name('create');
        Route::post('/', [PembelianController::class, 'store'])->name('store');
        Route::get('/{pembelian}', [PembelianController::class, 'show'])->name('show');
        Route::get('/{pembelian}/edit', [PembelianController::class, 'edit'])->name('edit');
        Route::put('/{pembelian}', [PembelianController::class, 'update'])->name('update');
        Route::delete('/{pembelian}', [PembelianController::class, 'destroy'])->name('destroy');
    });

    // Stok (read-only untuk semua role)
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
    });

    // Stok Opname (input oleh karyawan & admin)
    Route::prefix('opname')->name('opname.')->group(function () {
        Route::get('/', [StokOpnameController::class, 'index'])->name('index');
        Route::get('/create', [StokOpnameController::class, 'create'])->name('create');
        Route::post('/', [StokOpnameController::class, 'store'])->name('store');
    });
});