<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SAdmin\AdminController;
use App\Http\Controllers\SAdmin\DashboardController;


Route::prefix('sadmin')->group(function() {
    Route::middleware('sadmin.auth')->group(function() {


        Route::get('logout', [AuthController::class, 'sadmin_logout'])->name('s_admin.logout');
        Route::prefix('dashboard')->name('s_admin.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });

        Route::prefix('admin')->name('sadmin-admin.')->group(function() {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::post('/store', [AdminController::class, 'store'])->name('store');
            Route::get('/short-url/{id}', [AdminController::class, 'adminUrl'])->name('adminUrl');
            Route::get('/download', [AdminController::class, 'exportUrlReport'])->name('download');
        });
        Route::get('/short-url', [AdminController::class, 'shortUrls'])->name('shortUrls.index');
    });

});

