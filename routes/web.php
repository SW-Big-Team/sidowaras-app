<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

// Login
Route::get('/', function () {
    return redirect()->route('login');
});


require __DIR__ . '/admin.php';
require __DIR__ . '/karyawan.php';
require __DIR__ . '/kasir.php';
require __DIR__ . '/shared.php';
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/karyawan/scanner', function () {
    return Inertia::render('Karyawan/Scanner');
})->name('scanner');

// // Profil pengguna yang sedang login
// Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth')->name('profile');

