<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function () {
    return Inertia::render('Auth/Login');
})->name('auth.login');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::prefix('api')->group(function () {
        Route::get('/types', [\App\Http\Controllers\TypesController::class, 'fetch']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    });

    Route::prefix('types')->group(function () {
        Route::get('/', [\App\Http\Controllers\TypesController::class, 'index'])->name('types.index');
        Route::post('/store', [\App\Http\Controllers\TypesController::class, 'store'])->name('types.store');
        Route::patch('/{type}', [\App\Http\Controllers\TypesController::class, 'update'])->name('types.update');
        Route::delete('/{type}', [\App\Http\Controllers\TypesController::class, 'destroy'])->name('types.destroy');
    });

    Route::prefix('varieties')->group(function () {
        Route::get('/', [\App\Http\Controllers\VarietiesController::class, 'index'])->name('varieties.index');
        Route::post('/store', [\App\Http\Controllers\VarietiesController::class, 'store'])->name('varieties.store');
        Route::patch('/{variety}', [\App\Http\Controllers\VarietiesController::class, 'update'])->name('varieties.update');
        Route::delete('/{variety}', [\App\Http\Controllers\VarietiesController::class, 'destroy'])->name('varieties.destroy');
    });
});
