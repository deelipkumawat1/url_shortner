<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SAdmin\DashboardController;


Route::middleware('sadmin.auth')->group(function() {
    Route::get('logout', [AuthController::class, 'sadmin_logout'])->name('s_admin.logout');
    Route::prefix('dashboard')->name('s_admin.')->group(function() {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
});

