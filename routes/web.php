<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        switch ($user->role->nama_role) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Karyawan':
                return redirect()->route('karyawan.dashboard');
            case 'Kasir':
                return redirect()->route('kasir.dashboard');
        }
    }
    return redirect()->route('login');
});

// Notification routes
Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('readAll');
    Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/karyawan.php';
require __DIR__ . '/kasir.php';
require __DIR__ . '/shared.php';

Auth::routes([
    'verify' => false,
    'reset' => false,
    'confirm' => false,
    'register' => false
]);