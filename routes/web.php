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
