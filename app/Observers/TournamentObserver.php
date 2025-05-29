<?php

namespace App\Observers;

use App\Models\Tournament;
use Carbon\Carbon;

class TournamentObserver
{
    public function retrieved(Tournament $tournament)
    {
        $today = Carbon::today();
        $originalStatus = $tournament->status;

        // Verificar que las fechas necesarias existen
        if (!$tournament->inscription_start_date || !$tournament->inscription_end_date || !$tournament->start_date || !$tournament->end_date) {
            return; // Evita errores si alguna fecha es nula
        }

        if ($today->lt($tournament->inscription_start_date)) {
            $tournament->status = 'pendiente';
        } elseif ($today->between($tournament->inscription_start_date, $tournament->inscription_end_date)) {
            $tournament->status = 'inscripcion';
        } elseif ($today->between($tournament->start_date, $tournament->end_date)) {
            $tournament->status = 'en_curso';
        } elseif ($today->gt($tournament->end_date)) {
            $tournament->status = 'finalizado';
        }

        if ($tournament->status !== $originalStatus) {
            $tournament->save();
        }
    }
}
