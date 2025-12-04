<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware('admin.auth')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
        Route::prefix('dashboard')->name('admin.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });
    });
});


