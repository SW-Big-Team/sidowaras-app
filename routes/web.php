<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome');
    })->name('welcome');
// });
