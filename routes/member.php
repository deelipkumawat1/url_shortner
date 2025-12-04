    <?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\DashboardController;

Route::prefix('dashboard')->name('member.')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
