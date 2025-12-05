<?php

use App\Http\Controllers\Admin\MemberController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ShortUrlController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware('admin.auth')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
        Route::prefix('dashboard')->name('admin.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });

        Route::prefix('short-url')->name('admin-url.')->group(function() {
            Route::get('/', [ShortUrlController::class, 'index'])->name('index');
            Route::get('/add', [ShortUrlController::class, 'create'])->name('create');
            Route::post('/store', [ShortUrlController::class, 'store'])->name('store');
            Route::put('/status/{id}', [ShortUrlController::class, 'status'])->name('status');
            Route::get('/download', [ShortUrlController::class, 'exportUrlReport'])->name('exportUrlReport');
        });

        Route::prefix('member')->name('admin-member.')->group(function() {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::post('/store', [MemberController::class, 'store'])->name('store');
            Route::get('/short-url/{id}', [MemberController::class, 'memberUrl'])->name('memberUrl');
        });
    });



});


