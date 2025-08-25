<?php

use Illuminate\Support\Facades\Route;
use Modules\Klinik\App\Http\Controllers\KlinikController;
use Modules\Klinik\App\Http\Controllers\KfaController;
use Modules\Klinik\App\Http\Controllers\KfaSyncController;

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

// Tambahkan route untuk API statistik klinik
Route::middleware(['auth'])->group(function () {
    // KFA Integration Routes
    Route::prefix('kfa')->name('kfa.')->group(function () {
        Route::get('/', [KfaController::class, 'index'])->name('index');
        Route::get('products', [KfaController::class, 'getProducts'])->name('products');
        Route::get('product-detail', [KfaController::class, 'getProductDetail'])->name('product-detail');
    });

    // KFA Sync Routes
    Route::prefix('kfa-sync')->name('kfa.sync.')->group(function () {
        Route::get('/', [KfaSyncController::class, 'index'])->name('index');
        Route::post('/sync', [KfaSyncController::class, 'sync'])->name('run');
        Route::post('/reset', [KfaSyncController::class, 'reset'])->name('reset');
        Route::get('/statistics', [KfaSyncController::class, 'statistics'])->name('statistics');
        Route::get('/pending', [KfaSyncController::class, 'pending'])->name('pending');
        Route::get('/synced', [KfaSyncController::class, 'synced'])->name('synced');
        Route::post('/match/{drug}', [KfaSyncController::class, 'showMatch'])->name('match');
    });
});
