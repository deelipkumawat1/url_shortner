<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SAdmin\DashboardController;

Route::prefix('dashboard')->name('s_admin.')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
