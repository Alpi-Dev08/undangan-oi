<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Tambahkan route untuk API statistik dashboard
Route::middleware(['auth'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->names('dashboard')->only('index');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/stats/daily-patients', [DashboardController::class, 'getDailyPatientStats'])->name('dashboard.stats.daily-patients');
    Route::get('/dashboard/stats/monthly-patients', [DashboardController::class, 'getMonthlyPatientStats'])->name('dashboard.stats.monthly-patients');
    Route::get('/dashboard/stats/comprehensive', [DashboardController::class, 'getComprehensiveStats'])->name('dashboard.stats.comprehensive');
});
