<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [CatalogController::class, 'index'])->name('catalog');

// ── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// ── Admin Panel (protected) ──────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');

    Route::resource('users', UserController::class)->except(['show']);
});
