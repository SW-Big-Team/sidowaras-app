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
        Route::post('/bayar-termin/{pembelian}', [PembelianController::class, 'bayarTermin'])->name('bayarTermin');
    });

    // Stok (read-only untuk semua role)
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
    });

    Route::prefix('stok-opname')->name('stokopname.')->group(function () {
        // Daftar riwayat stock opname (bisa dilihat semua role)
        Route::get('/', [StokOpnameController::class, 'index'])->name('index');
        
        // Form input stock opname (hanya Karyawan & Admin)
        Route::get('/create', [StokOpnameController::class, 'create'])
            ->middleware('role:Admin|Karyawan')
            ->name('create');
        
        // Simpan hasil input (hanya Karyawan & Admin)
        Route::post('/', [StokOpnameController::class, 'store'])
            ->middleware('role:Admin|Karyawan')
            ->name('store');
        
        // Detail stock opname (bisa dilihat semua role)
        Route::get('/{id}', [StokOpnameController::class, 'show'])->name('show');
    });
});

