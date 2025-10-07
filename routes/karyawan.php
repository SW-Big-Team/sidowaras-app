<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Karyawan'])->prefix('karyawan')->group(function () {

    //Dashboard karyawan
    Route::get('/dashboard', fn() => view('dashboard.karyawan'))->name('karyawan.dashboard');
});
