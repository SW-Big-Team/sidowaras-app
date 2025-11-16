<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/session/check', function () {
    return response()->json([
        'authenticated' => Auth::check(),
    ]);
});
