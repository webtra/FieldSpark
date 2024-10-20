<?php

use App\Http\Controllers\CultivarsController;
use App\Http\Controllers\UsersController;
use App\Http\Requests\StoreCultivarsRequest;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // General Menu Links //
    Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');

    Route::get('/cultivar', [CultivarsController::class, 'index'])->name('cultivar.index');
    Route::get('/cultivars/pdf', [CultivarsController::class, 'downloadPDF'])->name('cultivars.pdf');

    Route::get('/user', [UsersController::class, 'index'])->name('user.index');
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('user.update');
});
