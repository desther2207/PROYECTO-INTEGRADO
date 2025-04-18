<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\TournamentController;
use App\Livewire\ShowTournaments;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('inicio');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tournaments', TournamentController::class)->middleware('auth:sanctum');

    Route::get('tournaments', ShowTournaments::class)->name('tournaments');
});


