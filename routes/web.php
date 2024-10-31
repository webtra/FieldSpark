<?php

use App\Http\Controllers\CropsController;
use App\Http\Controllers\CultivarsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('cultivar')->group(function () {
        Route::get('/', [CultivarsController::class, 'index'])->name('cultivar.index');
        Route::get('/download', [CultivarsController::class, 'download'])->name('cultivar.download');
    });

    Route::prefix('crop')->group(function () {
        Route::get('/', [CropsController::class, 'index'])->name('crop.index');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('user.index');
        Route::delete('/delete/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
        Route::put('/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
        Route::post('/store', [UsersController::class, 'store'])->name('user.store');
    });
});
