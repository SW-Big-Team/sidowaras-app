<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'role:Admin'])->prefix('adminx')->group(function () {

    //Dashboard Admin
    Route::get('/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
    Route::get('/dashboard/karyawan', fn() => view('dashboard.karyawan'))->name('karyawan.dashboard');
    Route::get('/dashboard/kasir', fn() => view('dashboard.kasir'))->name('kasir.dashboard');

    //User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    
});
