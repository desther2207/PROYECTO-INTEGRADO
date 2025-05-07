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

        $bracket->generateGames(); // --> Así se llama al método del modelo

        return redirect()->back()->with('success', 'Partidos generados correctamente.');
    }
}
