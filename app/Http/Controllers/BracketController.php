<?php

namespace App\Http\Controllers;

use App\Models\Bracket;
use App\Models\Game;


class BracketController extends Controller
{
    public function generateGames(Bracket $bracket)
    {
        $pairs = $bracket->category->pairs()
            ->where('tournament_id', $bracket->tournament_id)
            ->inRandomOrder()
            ->get();

        $totalPairs = $pairs->count();
        $nextPowerOfTwo = pow(2, ceil(log($totalPairs) / log(2)));
        $byes = $nextPowerOfTwo - $totalPairs;

        for ($i = 0; $i < $byes; $i++) {
            $pairs->push(null);
        }

        for ($i = 0; $i < $pairs->count(); $i += 2) {
            $pair1 = $pairs[$i];
            $pair2 = $pairs[$i + 1];

            if ($pair1 && $pair2) {
                Game::create([
                    'bracket_id' => $bracket->id,
                    'pair_one_id' => $pair1->id,
                    'pair_two_id' => $pair2->id,
                    'venue_id' => 1,
                    'court_id' => 1, 
                    'start_game_date' => now()->addDays(1),
                    'end_game_date' => now()->addDays(1)->addHour(),
                    'result' => '',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Partidos generados correctamente.');
    }
}
