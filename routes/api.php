<?php

use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SummaryApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{product}', [ProductApiController::class, 'show']);
    Route::get('/summary', SummaryApiController::class);
});
