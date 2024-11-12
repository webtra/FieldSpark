<?php

use App\Http\Controllers\AgrochemicalProgramApplicationsController;
use App\Http\Controllers\AgrochemicalProgramsController;
use App\Http\Controllers\AgrochemicalsController;
use App\Http\Controllers\CropsController;
use App\Http\Controllers\CultivarsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupportTicketsController;
use App\Http\Controllers\UsersController;
use App\Models\AgrochemicalProgramApplications;
use App\Models\AgrochemicalPrograms;
use App\Models\SupportTickets;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::prefix('api')->group(function () {
        Route::get('/fetch-cultivars', [CultivarsController::class, 'fetchCultivars']);
        Route::get('/fetch-crops', [CropsController::class, 'fetchCrops']);
        Route::get('/fetch-agrochemicals', [AgrochemicalsController::class, 'fetchAgrochemicals']);
        Route::post('/generate-application-sheet', [AgrochemicalProgramApplicationsController::class, 'generateApplicationSheet']);
    });

    Route::prefix('agrochemical')->group(function () {
        Route::get('/', [AgrochemicalsController::class, 'index'])->name('agrochemical.index');
        Route::delete('/{id}', [AgrochemicalsController::class, 'destroy'])->name('agrochemical.destroy');
        Route::put('/{id}', [AgrochemicalsController::class, 'update'])->name('agrochemical.update');
        Route::post('/store', [AgrochemicalsController::class, 'store'])->name('agrochemical.store');
    });

    Route::prefix('agrochemical-program')->group(function () {
        Route::get('/', [AgrochemicalProgramsController::class, 'index'])->name('agrochemical.program.index');
        Route::delete('/{id}', [AgrochemicalProgramsController::class, 'delete'])->name('agrochemical.program.delete');
        Route::put('/{id}', [AgrochemicalProgramsController::class, 'update'])->name('agrochemical.program.update');
        Route::post('/store', [AgrochemicalProgramsController::class, 'store'])->name('agrochemical.program.store');
    });

    Route::prefix('agrochemical-program/application')->group(function () {
        Route::get('/', [AgrochemicalProgramApplicationsController::class, 'index'])->name('agrochemical.program.application.index');
        Route::put('/{id}', [AgrochemicalProgramApplicationsController::class, 'update'])->name('agrochemical.program.application.update');
        Route::post('/save', [AgrochemicalProgramApplicationsController::class, 'save']);
        Route::get('/fill/{plannedDate}', [AgrochemicalProgramApplicationsController::class, 'showApplicationForm'])
            ->name('application.sheet.fill');

        Route::post('/save', [AgrochemicalProgramApplicationsController::class, 'saveApplicationForm'])
            ->name('application.sheet.save');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/stats', [DashboardController::class, 'stats']);
        Route::get('/activities', [DashboardController::class, 'activities']);
    });

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

    // Define API routes for support tickets within the 'support-tickets' prefix
    Route::prefix('support-tickets')->group(function () {

        // Route to retrieve a list of all support tickets
        Route::get('/', [SupportTicketsController::class, 'index'])
            ->name('support.tickets.index');

        // Route to create a new support ticket
        Route::post('/store', [SupportTicketsController::class, 'store'])
            ->name('support.tickets.store');

        // Route to retrieve a specific support ticket by ID
        Route::get('/{id}', [SupportTicketsController::class, 'show'])
            ->name('support.tickets.show');

        // Route to add a reply to a specific support ticket
        Route::post('/{id}/reply', [SupportTicketsController::class, 'reply'])
            ->name('support.tickets.reply');

        Route::post('/{id}/close', [SupportTicketsController::class, 'close'])->name('support.tickets.close');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('user.index');
        Route::delete('/delete/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
        Route::put('/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
        Route::post('/store', [UsersController::class, 'store'])->name('user.store');
    });
});
