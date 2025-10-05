<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;

// CSRF token endpoint (untuk axios di React/Inertia)
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Halaman public
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

// Auth routes 
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth'); 

Route::get('/profile', [AuthController::class, 'profile'])
    ->middleware('auth');

// Multi-role protected routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-area', fn() => response()->json([
        'message' => 'Halo Admin'
    ]));
});

Route::middleware(['auth', 'role:Admin'])->prefix('adminx')->group(function () {
    
    Route::resource('users', UserController::class);
});

Route::middleware(['auth', 'role:Admin,Karyawan'])->group(function () {
    Route::get('/karyawan-admin-area', fn() => response()->json([
        'message' => 'Halo Admin atau Karyawan'
    ]));
});

Route::middleware(['auth', 'role:Admin,Kasir'])->group(function () {
    Route::get('/kasir-admin-area', fn() => response()->json([
        'message' => 'Halo Admin atau Kasir'
    ]));
});

Route::middleware(['auth', 'role:Admin,Karyawan,Kasir'])->group(function () {
    Route::get('/semua-role', fn() => response()->json([
        'message' => 'Halo Semua Role'
    ]));
});