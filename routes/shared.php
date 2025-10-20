<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Obat\SatuanObatController;
use App\Http\Controllers\Obat\KandunganObatController;
use App\Http\Controllers\Obat\ObatController;
use App\Http\Controllers\PembelianController;


Route::middleware(['auth', 'role:Admin,Karyawan,Kasir'])->prefix('shared')->group(function () {

    // KATEGORI OBAT
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriObatController::class, 'index'])->name('index');
        Route::get('/create', [KategoriObatController::class, 'create'])->name('create');
        Route::post('/', [KategoriObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriObatController::class, 'destroy'])->name('destroy');
    });

    // SATUAN OBAT
    Route::prefix('satuan')->name('satuan.')->group(function () {
        Route::get('/', [SatuanObatController::class, 'index'])->name('index');
        Route::get('/create', [SatuanObatController::class, 'create'])->name('create');
        Route::post('/', [SatuanObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SatuanObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SatuanObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [SatuanObatController::class, 'destroy'])->name('destroy');
    });

    // KANDUNGAN OBAT
    Route::prefix('kandungan')->name('kandungan.')->group(function () {
        Route::get('/', [KandunganObatController::class, 'index'])->name('index');
        Route::get('/create', [KandunganObatController::class, 'create'])->name('create');
        Route::post('/', [KandunganObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KandunganObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KandunganObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [KandunganObatController::class, 'destroy'])->name('destroy');
    });

    // input obat
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/create', [ObatController::class, 'create'])->name('create');
        Route::post('/', [ObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');
    });

    // pembelian obat

    Route::prefix('pembelian')->name('pembelian.')->group(function () {
        Route::get('/', [PembelianController::class, 'index'])->name('index');
        Route::get('/create', [PembelianController::class, 'create'])->name('create');
        Route::post('/', [PembelianController::class, 'store'])->name('store');
        Route::get('/{pembelian}', [PembelianController::class, 'show'])->name('show');
        Route::get('/{pembelian}/edit', [PembelianController::class, 'edit'])->name('edit');
        Route::put('/{pembelian}', [PembelianController::class, 'update'])->name('update');
        Route::delete('/{pembelian}', [PembelianController::class, 'destroy'])->name('destroy');
    });

});
