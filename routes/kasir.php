<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Kasir,Admin'])->prefix('kasir')->name('kasir.')->group(function () {

    // Dashboard kasir
    Route::get('/dashboard', fn() => view('kasir.index'))->name('dashboard');
    
    // Transaksi / POS
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/pos', fn() => view('kasir.transaksi.pos'))->name('pos');
        Route::post('/process', fn() => redirect()->back())->name('process'); // Controller akan ditambahkan nanti
        Route::get('/riwayat', fn() => view('kasir.transaksi.riwayat'))->name('riwayat');
    });

    // Cart Approval
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/approval', fn() => view('kasir.cart.approval'))->name('approval');
        Route::post('/{id}/approve', fn() => redirect()->back())->name('approve'); // Controller akan ditambahkan nanti
        Route::post('/{id}/reject', fn() => redirect()->back())->name('reject'); // Controller akan ditambahkan nanti
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/transaksi', fn() => view('kasir.laporan.transaksi'))->name('transaksi');
        Route::get('/harian', fn() => view('kasir.laporan.transaksi'))->name('harian');
    });
});

