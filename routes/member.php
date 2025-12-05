    <?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\ShortUrlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\DashboardController;


Route::middleware('member.auth')->group(function() {
    Route::prefix('member')->group(function(){
        Route::get('/logout', [AuthController::class, 'member_logout'])->name('member.logout');
        Route::prefix('dashboard')->name('member.')->group(function() {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        });

        // Short Url Routs.

        Route::prefix('short-url')->name('member-url.')->group(function() {
            Route::get('/', [ShortUrlController::class, 'index'])->name('index');
            Route::get('/add', [ShortUrlController::class, 'create'])->name('create');
            Route::post('/store', [ShortUrlController::class, 'store'])->name('store');
            Route::put('/status/{id}', [ShortUrlController::class, 'status'])->name('status');
            Route::get('/download', [ShortUrlController::class, 'exportUrlReport'])->name('exportUrlReport');
        });
    });
});
Route::get('s/{short_url}', [ShortUrlController::class, 'redirect'])->name('member-url.redirect');



