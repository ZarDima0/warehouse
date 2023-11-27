<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;
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
   Route::post('/reserve',  [ProductController::class, 'reserveProducts'])->name('product.reverse');
    Route::post('/release',  [ProductController::class, 'releaseProducts'])->name('product.release');
});
