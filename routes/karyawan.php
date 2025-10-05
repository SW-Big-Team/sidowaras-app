<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Karyawan'])
    ->prefix('karyawan')
    ->group(function () {
        Route::get('/area', fn() => response()->json([
            'message' => 'Halo Karyawan'
        ]));
    });
