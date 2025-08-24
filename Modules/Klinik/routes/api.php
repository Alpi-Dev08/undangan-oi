<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Klinik\App\Http\Controllers\KfaController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('klinik', fn (Request $request) => $request->user())->name('klinik');
    
    // KFA Integration Routes
    Route::prefix('kfa')->name('kfa.')->group(function () {
        Route::get('product-detail', [KfaController::class, 'getProductDetail'])->name('product-detail');
        Route::get('products', [KfaController::class, 'getProducts'])->name('products');
        Route::post('sync-drug', [KfaController::class, 'syncDrugWithKfa'])->name('sync-drug');
        Route::get('drugs-with-kfa', [KfaController::class, 'getDrugsWithKfa'])->name('drugs-with-kfa');
    });
});
