<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Admin Routes
    Route::middleware(['role:administrador'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', function () { return Inertia::render('Admin/Users'); })->name('users.index');
        // Game management for Admin
        Route::resource('games', \App\Http\Controllers\GameController::class);
    });

    // Manager Routes
    Route::middleware(['role:gestor'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/dashboard', function () { return Inertia::render('Manager/Dashboard'); })->name('dashboard');
        // Game management for Manager
        Route::resource('games', \App\Http\Controllers\GameController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    });

    // Player Routes
    Route::middleware(['role:jugador'])->prefix('player')->name('player.')->group(function () {
        Route::get('/games', [\App\Http\Controllers\GameController::class, 'playerIndex'])->name('games.index');
        Route::get('/games/{game}', [\App\Http\Controllers\GameController::class, 'playerShow'])->name('games.show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
