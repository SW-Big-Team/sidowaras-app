<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Kasir'])
    ->prefix('kasir')
    ->group(function () {
        Route::get('/area', fn() => response()->json([
            'message' => 'Halo Kasir'
        ]));
    });
