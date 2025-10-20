<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


Route::middleware(['auth', 'role:Admin'])->prefix('adminx')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', fn() => view('admin.index'))->name('dashboard');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
    
    // Admin can access all karyawan routes
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/keranjang', fn() => view('karyawan.cart.index'))->name('keranjang');
        Route::get('/stock', fn() => view('karyawan.inventory.index'))->name('stock.index');
        Route::get('/stock/tambah', fn() => view('karyawan.inventory.tambah'))->name('stock.tambah');
    });

    // Admin can access all kasir routes (add when needed)
    Route::prefix('kasir')->name('kasir.')->group(function () {
        // Kasir specific routes will go here
    });
});
