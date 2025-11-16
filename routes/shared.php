<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\Shared\StokController;
use App\Http\Controllers\Shared\StokOpnameController;

use App\Http\Controllers\Obat\ObatController;
use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Obat\SatuanObatController;
use App\Http\Controllers\Obat\KandunganObatController;

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
        // Route::get('/', [StokOpnameController::class, 'index'])->name('index'); change to dd()
        Route::get('/', function () {
            dd('ongoing');
        })->name('index');
        Route::get('/create', [StokOpnameController::class, 'create'])->name('create');
        Route::post('/', [StokOpnameController::class, 'store'])->name('store');
    });
});

// Alias routes (named without `admin.`) so views that call `route('satuan.index')`
// or `route('obat.index')` won't fail when rendering. These routes are
// protected by the Admin role to match existing admin behavior.
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/create', [ObatController::class, 'create'])->name('create');
        Route::post('/', [ObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriObatController::class, 'index'])->name('index');
        Route::get('/create', [KategoriObatController::class, 'create'])->name('create');
        Route::post('/', [KategoriObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KategoriObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KategoriObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [KategoriObatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('satuan')->name('satuan.')->group(function () {
        Route::get('/', [SatuanObatController::class, 'index'])->name('index');
        Route::get('/create', [SatuanObatController::class, 'create'])->name('create');
        Route::post('/', [SatuanObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SatuanObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SatuanObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [SatuanObatController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('kandungan')->name('kandungan.')->group(function () {
        Route::get('/', [KandunganObatController::class, 'index'])->name('index');
        Route::get('/create', [KandunganObatController::class, 'create'])->name('create');
        Route::post('/', [KandunganObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KandunganObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KandunganObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [KandunganObatController::class, 'destroy'])->name('destroy');
    });
});