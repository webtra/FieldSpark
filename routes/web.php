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
        Route::get('/varieties', [\App\Http\Controllers\VarietiesController::class, 'fetch']);
        Route::get('/storerooms', [\App\Http\Controllers\StoreroomsController::class, 'fetch']);
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

    Route::prefix('fields')->group(function () {
        Route::get('/', [\App\Http\Controllers\FieldsController::class, 'index'])->name('fields.index');
        Route::post('/store', [\App\Http\Controllers\FieldsController::class, 'store'])->name('fields.store');
        Route::patch('/{field}', [\App\Http\Controllers\FieldsController::class, 'update'])->name('fields.update');
        Route::delete('/{field}', [\App\Http\Controllers\FieldsController::class, 'destroy'])->name('fields.destroy');
    });

    Route::prefix('storerooms')->group(function () {
        Route::get('/', [\App\Http\Controllers\StoreroomsController::class, 'index'])->name('storerooms.index');
        Route::post('/store', [\App\Http\Controllers\StoreroomsController::class, 'store'])->name('storerooms.store');
        Route::patch('/{storeroom}', [\App\Http\Controllers\StoreroomsController::class, 'update'])->name('storerooms.update');
        Route::delete('/{storeroom}', [\App\Http\Controllers\StoreroomsController::class, 'destroy'])->name('storerooms.destroy');
        Route::get('/{storeroom}/dashboard', [\App\Http\Controllers\StoreroomsController::class, 'showDashboard'])->name('storerooms.dashboard');
        Route::get('/{storeroom}/dashboard/create/item', [\App\Http\Controllers\ItemsController::class, 'create'])->name('items.create');
    });

    Route::prefix('items')->group(function () {
        Route::get('/', [\App\Http\Controllers\ItemsController::class, 'index'])->name('items.index');
        Route::post('/store', [\App\Http\Controllers\ItemsController::class, 'store'])->name('items.store');
        Route::patch('/{item}', [\App\Http\Controllers\ItemsController::class, 'update'])->name('items.update');
        Route::delete('/{item}', [\App\Http\Controllers\ItemsController::class, 'destroy'])->name('items.destroy');
    });
});
