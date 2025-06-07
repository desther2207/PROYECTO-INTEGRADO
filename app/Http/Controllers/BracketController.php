<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\Game;


class BracketController extends Controller
{

    public function generateGamesManually(Bracket $bracket)
    {
        if ($bracket->games()->count()) {
            return redirect()->back()->with('error', 'Los partidos ya fueron generados.');
        }

        $success = $bracket->generateGames();

        if ($success) {
            return redirect()->back()->with('success', '✅ Partidos generados automáticamente.');
        } else {
            return redirect()->back()->with('warning', '⚠️ No se han generado partidos: se necesitan al menos 3 parejas.');
        }
    }
}
