<?php

use App\Http\Controllers\AgrochemicalsController;
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

    Route::prefix('agrochemical')->group(function () {
        Route::get('/', [AgrochemicalsController::class, 'index'])->name('agrochemical.index');
        Route::delete('/{agrochemical}', [AgrochemicalsController::class, 'destroy'])->name('agrochemical.destroy');
        Route::put('/{agrochemical}', [AgrochemicalsController::class, 'update'])->name('agrochemical.update');
        Route::post('/store', [AgrochemicalsController::class, 'store'])->name('agrochemical.store');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('cultivar')->group(function () {
        Route::get('/', [CultivarsController::class, 'index'])->name('cultivar.index');
        Route::delete('/{id}', [CultivarsController::class, 'destroy'])->name('cultivar.destroy');
        Route::put('/{id}', [CultivarsController::class, 'update'])->name('cultivar.update');
        Route::post('/store', [CultivarsController::class, 'store'])->name('cultivar.store');
    });

    Route::prefix('crop')->group(function () {
        Route::get('/', [CropsController::class, 'index'])->name('crop.index');
        Route::delete('/{crop}', [CropsController::class, 'destroy'])->name('crop.destroy');
        Route::put('/{crop}', [CropsController::class, 'update'])->name('crop.update');
        Route::post('/store', [CropsController::class, 'store'])->name('crop.store');
    });

    Route::prefix('api')->group(function () {
        Route::get('/fetch-cultivars', [CultivarsController::class, 'fetchCultivars']);
        Route::get('/fetch-agrochemicals', [CultivarsController::class, 'fetchAgrochemicals']);
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('user.index');
        Route::delete('/delete/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
        Route::put('/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
        Route::post('/store', [UsersController::class, 'store'])->name('user.store');
    });
});
