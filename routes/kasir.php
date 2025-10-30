<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kasir\CartApprovalController;
use App\Http\Controllers\Kasir\TransaksiController;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
use App\Http\Controllers\Shared\StokController;
=======
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)

Route::middleware(['auth', 'role:Kasir,Admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn() => view('kasir.index'))->name('dashboard');
<<<<<<< HEAD
=======
    
    // Transaksi / POS
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'index'])->name('riwayat');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
=======
use App\Http\Controllers\Shared\StokController;

Route::middleware(['auth', 'role:Kasir,Admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn() => view('kasir.index'))->name('dashboard');
>>>>>>> e04ebff (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)

    // Cart Approval
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/approval', [CartApprovalController::class, 'index'])->name('approval');
<<<<<<< HEAD
        Route::post('/{cart}/approve', [CartApprovalController::class, 'approve'])->name('approve');
=======
<<<<<<< HEAD
        Route::get('/{cart}/approve', [CartApprovalController::class, 'showPayment'])->name('showPayment');
        Route::post('/process-payment', [CartApprovalController::class, 'processPayment'])->name('processPayment');
>>>>>>> 2d4f65f (Add Cart functionality and update Bootstrap version)
        Route::post('/{cart}/reject', [CartApprovalController::class, 'reject'])->name('reject');
    });

    // Riwayat Transaksi
=======

Route::middleware(['auth', 'role:Kasir,Admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', fn() => view('kasir.index'))->name('dashboard');
    
    // Transaksi / POS
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'index'])->name('riwayat');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });

<<<<<<< HEAD
=======
=======
    // Cart Approval
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/approval', [CartApprovalController::class, 'index'])->name('approval');
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
        Route::post('/{cart}/approve', [CartApprovalController::class, 'approve'])->name('approve');
        Route::post('/{cart}/reject', [CartApprovalController::class, 'reject'])->name('reject');
    });

<<<<<<< HEAD
<<<<<<< HEAD
    // Pembelian Obat
>>>>>>> 5c848fc (Add Cart functionality and update Bootstrap version)
=======
    // Riwayat Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'index'])->name('riwayat');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });

>>>>>>> e04ebff (Add new views and controllers for Stok and Transaksi management, update relationships in models, and enhance kategori forms.)
=======
    // Pembelian Obat
>>>>>>> f5d5d3d (Add Cart functionality and update Bootstrap version)
    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/transaksi', fn() => view('kasir.laporan.transaksi'))->name('transaksi');
        Route::get('/harian', fn() => view('kasir.laporan.transaksi'))->name('harian');
    });

    // Manajemen Stok (hanya lihat & input via pembelian)
    Route::prefix('stok')->name('stok.')->group(function () {
        Route::get('/', [StokController::class, 'index'])->name('index');
    });
    Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian.index');
});