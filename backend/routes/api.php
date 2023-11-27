<?php

use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\StoreHouse\StoreHouseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('product')->group(function () {
    Route::post('/reserve', [ProductController::class, 'reserveProducts'])->name('product.reverse');
    Route::post('/release', [ProductController::class, 'releaseProducts'])->name('product.release');
});

Route::prefix('store-house')->group(function () {
    Route::post('/countProducts', [StoreHouseController::class, 'getCountProduct'])->name('product.reverse');
});
