<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;


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

// Halaman login (GET)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

// Proses login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Logout (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Profil pengguna yang sedang login
// Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth')->name('profile');


require __DIR__ . '/admin.php';
require __DIR__ . '/karyawan.php';
require __DIR__ . '/kasir.php';