<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Kasir'])->prefix('kasir')->group(function () {

    //Dashboard kasir
    Route::get('/dashboard', fn() => view('dashboard.kasir'))->name('kasir.dashboard');
});
