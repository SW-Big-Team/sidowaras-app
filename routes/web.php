<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;

// Route::group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('welcome');

    Route::get('/karyawan/scanner', function () {
        return Inertia::render('Karyawan/Scanner');
    })->name('scanner');
// });

// CSRF token endpoint (untuk axios di React/Inertia)
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Halaman public
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');

    Route::get('/karyawan/scanner', function () {
        return Inertia::render('Karyawan/Scanner');
    })->name('scanner');

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

// Admin Routes with Material Dashboard Layout
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');
});

Route::get('/login', function () {
        return view('auth.login');
    })->name('login');