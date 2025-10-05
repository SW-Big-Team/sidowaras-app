<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Halaman public
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');



require __DIR__ . '/admin.php';
require __DIR__ . '/karyawan.php';
require __DIR__ . '/kasir.php';
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/karyawan/scanner', function () {
    return Inertia::render('Karyawan/Scanner');
})->name('scanner');

// // Profil pengguna yang sedang login
// Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth')->name('profile');

// Admin Routes with Material Dashboard Layout
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

// Route::get('/login', function () {
//         return view('auth.login');
//     })->name('login');
