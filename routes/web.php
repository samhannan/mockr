<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\ProfileController;
use App\Models\Endpoint;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group([
        'as' => 'endpoints.',
        'prefix' => 'endpoints',
    ], function () {
        Route::get('/', [EndpointController::class, 'index'])->name('index')->can('viewAny', Endpoint::class);
        Route::get('/create', [EndpointController::class, 'create'])->name('create')->can('create', Endpoint::class);
        Route::post('/', [EndpointController::class, 'store'])->name('store')->can('create', Endpoint::class);
        Route::get('/{endpoint}', [EndpointController::class, 'show'])->name('show')->can('view', 'endpoint');
        Route::get('/{endpoint}/edit', [EndpointController::class, 'edit'])->name('edit')->can('update', 'endpoint');
        Route::patch('/{endpoint}', [EndpointController::class, 'update'])->name('update')->can('update', 'endpoint');
        Route::delete('/{endpoint}', [EndpointController::class, 'destroy'])->name('destroy')->can('delete', 'endpoint');
    });
});

require __DIR__.'/auth.php';
