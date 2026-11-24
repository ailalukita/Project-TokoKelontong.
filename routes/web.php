<?php

// routes/web.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    // admin & kasir
    Route::resource('customers', CustomerController::class)->except(['show', 'create']);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'show']);

    // khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class)->except(['show', 'create']);
        Route::resource('products', ProductController::class)->except(['show']);
    });
});
