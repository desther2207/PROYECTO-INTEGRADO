<?php

namespace App\Observers;

use App\Models\Pair;
use App\Models\Bracket;

class PairObserver
{
    /**
     * Cuando se crea o actualiza una pareja.
     */
    public function saved(Pair $pair)
    {
        $tournament = $pair->tournament;

        // ✅ Actualizar current_pairs
        $confirmedPairs = $tournament->pairs()
            ->whereNotNull('player_2_id')
            ->where('status', 'confirmada')
            ->count();

        $tournament->current_pairs = $confirmedPairs;
        $tournament->save();

        // ✅ Generar brackets y partidos automáticamente si se alcanza el max_pairs
        if ($confirmedPairs >= $tournament->max_pairs) {

            // Asegurar que hay categorías
            if ($tournament->categories()->count() == 0) {
                return;
            }

            foreach ($tournament->categories as $category) {
                // Crear bracket si no existe
                $bracket = Bracket::firstOrCreate([
                    'tournament_id' => $tournament->id,
                    'category_id' => $category->id,
                ], [
                    'status' => 'En curso',
                    'type' => 'principal',
                ]);

                // Si no hay partidos → generar
                if ($bracket->games()->count() === 0) {
                    $bracket->generateGames();
                }
            }
        }
    }

    /**
     * Cuando se elimina una pareja.
     */
    public function deleted(Pair $pair)
    {
        $tournament = $pair->tournament;

        // ✅ Actualizar current_pairs al eliminar
        $confirmedPairs = $tournament->pairs()
            ->whereNotNull('player_2_id')
            ->where('status', 'confirmada')
            ->count();

        $tournament->current_pairs = $confirmedPairs;
        $tournament->save();
    }
}
