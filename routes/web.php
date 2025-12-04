<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('login')->name('login.')->group(function() {
    Route::get('/', [AuthController::class, 'index'])->name('index');
    Route::post('/store', [AuthController::class, 'store'])->name('store');
});

require __DIR__ . '/admin.php';
require __DIR__ . '/member.php';
require __DIR__ . '/s_admin.php';
