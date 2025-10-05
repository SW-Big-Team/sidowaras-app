<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;

// Route::group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('welcome');

    Route::get('/karyawan/scanner', function () {
        return Inertia::render('Karyawan/Scanner');
    })->name('scanner');
// });

Route::middleware(['auth', 'role:Admin'])->prefix('adminx')->group(function () {
    
    
    Route::resource('users', UserController::class);

});