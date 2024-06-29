<?php

use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UserRolesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UserRolesController::class, 'dashboard'])->name('dashboard');

    Route::get('/services', [UserRolesController::class, 'viewService'])->name('service.view');
    Route::get('/services/create', [UserRolesController::class, 'createService'])->name('service.create');

    Route::post('/api/services/create', [ServicesController::class, 'createNewService'])->name('service.new.create');
});
