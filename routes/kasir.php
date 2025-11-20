<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kasir\CartApprovalController;
use App\Http\Controllers\Kasir\TransaksiController;
use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Shared\StokController;

Route::middleware(['auth', 'role:Kasir,Admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Cart Approval
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/approval', [CartApprovalController::class, 'index'])->name('approval');
        Route::get('/{cart}/approve', [CartApprovalController::class, 'showPayment'])->name('showPayment');
        Route::post('/process-payment', [CartApprovalController::class, 'processPayment'])->name('processPayment');
        Route::post('/{cart}/reject', [CartApprovalController::class, 'reject'])->name('reject');
    });

    // Riwayat Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'index'])->name('riwayat');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });

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