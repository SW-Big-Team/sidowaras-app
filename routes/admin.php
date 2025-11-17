<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Obat\ObatController;
use App\Http\Controllers\Obat\KategoriObatController;
use App\Http\Controllers\Obat\SatuanObatController;
use App\Http\Controllers\Obat\KandunganObatController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Shared\StokOpnameController;

Route::middleware(['auth', 'role:Admin'])->prefix('adminx')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.index'))->name('dashboard');

    // Manajemen Obat (Hanya Admin)
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

    Route::prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Stok (Hanya akses ke shared)
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');

    Route::get('/pembelian', function () {
        return redirect()->route('pembelian.index');
    })->name('pembelian.index');

    // Riwayat Transaksi & Laporan
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', fn() => view('admin.laporan.index'))->name('index');
    });

    // Manajemen Pengguna
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::patch('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Shift
    Route::prefix('shift')->name('shift.')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('index');
        Route::post('/', [ShiftController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ShiftController::class, 'edit'])->name('edit');
        Route::delete('/{id}', [ShiftController::class, 'destroy'])->name('destroy');
    });

    // Approval Stok Opname
    Route::prefix('stok-opname')->name('stokopname.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.stokopname.pending');
        })->name('index');
        Route::get('/pending', [StokOpnameController::class, 'pending'])
            ->name('pending');
        Route::post('/{id}/approve', [StokOpnameController::class, 'approve'])
            ->name('approve');
        Route::post('/{id}/reject', [StokOpnameController::class, 'reject'])
            ->name('reject');
    });
});