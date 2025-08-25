<?php

use Illuminate\Support\Facades\Route;
use Modules\Klinik\App\Http\Controllers\KlinikController;
use Modules\Klinik\App\Http\Controllers\KfaController;

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
});
