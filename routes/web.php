<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Admin\PlantsController as AdminPlantsController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;

Route::get('/', [PlantsController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrdersController::class)->only(['index', 'create', 'store']);
    Route::resource('users', UsersController::class)->only(['show', 'edit', 'update']);
});

Route::resource('plants', PlantsController::class)->only(['index', 'show']);

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('plants', AdminPlantsController::class)->except(['show']);
    Route::resource('users', AdminUsersController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
