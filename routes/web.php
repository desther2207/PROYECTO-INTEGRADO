<?php

use App\Http\Controllers\BracketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PairController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\VenueController;
use App\Livewire\ShowTournaments;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('inicio');

// Lo saco del middleware para evitar problema con el enlace de invitación
Route::get('/pairs/join/{pair}', [PairController::class, 'join'])->name('pairs.join');

Route::get('/pairs/create', [PairController::class, 'create'])->name('pairs.create');
Route::post('/pairs/store', [PairController::class, 'store'])->name('pairs.store');
Route::get('/pairs/invite/{pair}', [PairController::class, 'invite'])->name('pairs.invite');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('tournaments', TournamentController::class)->middleware('auth:sanctum');

    Route::get('tournaments', ShowTournaments::class)->name('tournaments');

    Route::get('/sedes/by-province/{province}', [VenueController::class, 'getSedesByProvince'])->name('sedes.byProvince');

    Route::post('/brackets/{bracket}/generate-games', [BracketController::class, 'generateGames'])->name('brackets.generateGames');

    Route::get('/tournaments/{tournament}/cuadros', [TournamentController::class, 'cuadros'])->name('tournaments.cuadros');


});


