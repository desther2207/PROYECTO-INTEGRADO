<?php

namespace App\Livewire;

use App\Models\Bracket;
use App\Models\Court;
use App\Models\Game;
use App\Models\Pair;
use App\Models\PositionPoint;
use App\Models\Ranking;
use App\Models\Tournament;
use Livewire\Component;

class BracketViewer extends Component
{
    public Tournament $tournament;
    public $selectedBracket = null;
    public array $sets = [];

    public $editingGameId = null;
    public array $editData = [];
    public array $availableCourts = [];
    public $venues = [];

    public function mount(Tournament $tournament)
    {
        $this->tournament = $tournament;

        $this->tournament->load(
            'categories',
            'brackets.games.pairOne.playerOne',
            'brackets.games.pairOne.playerTwo',
            'brackets.games.pairTwo.playerOne',
            'brackets.games.pairTwo.playerTwo'
        );

        $this->venues = $tournament->venues()->with('courts')->get();

        $firstCategory = $this->tournament->categories->first();
        if ($firstCategory) {
            $this->selectedBracket = $firstCategory->id . '-principal';
        }
    }

    public function startEdit($gameId)
    {
        $this->editingGameId = $gameId;

        $game = Game::with('court')->findOrFail($gameId);

        $this->editData[$gameId] = [
            'pair_one_id' => $game->pair_one_id,
            'pair_two_id' => $game->pair_two_id,
            'start_game_date' => optional($game->start_game_date)->format('Y-m-d\TH:i'),
            'venue_id' => $game->venue_id,
            'court_id' => $game->court_id,
        ];

        $this->loadCourts($gameId);
    }

    public function loadCourts($gameId)
    {
        $venueId = $this->editData[$gameId]['venue_id'] ?? null;
        $this->availableCourts[$gameId] = Court::where('venue_id', $venueId)->get();
    }

    public function saveEdit($gameId)
    {
        $data = $this->editData[$gameId];

        $this->validate([
            "editData.$gameId.pair_one_id" => 'required|different:editData.' . $gameId . '.pair_two_id',
            "editData.$gameId.pair_two_id" => 'required',
            "editData.$gameId.start_game_date" => 'required|date',
            "editData.$gameId.venue_id" => 'required|exists:venues,id',
            "editData.$gameId.court_id" => 'required|exists:courts,id',
        ]);

        $game = Game::findOrFail($gameId);
        $bracket = $game->bracket;

        $oldPairOneId = $game->pair_one_id;
        $oldPairTwoId = $game->pair_two_id;

        // Intercambiar pareja 1
        $existingGame1 = $bracket->games()
            ->where('id', '!=', $gameId)
            ->where(function ($q) use ($data) {
                $q->where('pair_one_id', $data['pair_one_id'])
                    ->orWhere('pair_two_id', $data['pair_one_id']);
            })->first();

        if ($existingGame1) {
            if ($existingGame1->pair_one_id === $data['pair_one_id']) {
                $existingGame1->pair_one_id = $oldPairOneId;
            } else {
                $existingGame1->pair_two_id = $oldPairOneId;
            }
        }

        // Intercambiar pareja 2
        $existingGame2 = $bracket->games()
            ->where('id', '!=', $gameId)
            ->where(function ($q) use ($data) {
                $q->where('pair_one_id', $data['pair_two_id'])
                    ->orWhere('pair_two_id', $data['pair_two_id']);
            })->first();

        if ($existingGame2) {
            if ($existingGame2->pair_one_id === $data['pair_two_id']) {
                $existingGame2->pair_one_id = $oldPairTwoId;
            } else {
                $existingGame2->pair_two_id = $oldPairTwoId;
            }
        }

        // Ahora actualizamos todos
        $game->update([
            'pair_one_id' => $data['pair_one_id'],
            'pair_two_id' => $data['pair_two_id'],
            'start_game_date' => $data['start_game_date'],
            'venue_id' => $data['venue_id'],
            'court_id' => $data['court_id'],
        ]);

        if ($existingGame1) $existingGame1->save();
        if ($existingGame2 && $existingGame2->id !== $existingGame1?->id) $existingGame2->save();

        $this->editingGameId = null;
        session()->flash('success', 'Partido actualizado correctamente.');
    }

    public function reportResult($gameId)
    {
        $game = Game::findOrFail($gameId);
        $sets = $this->sets[$gameId] ?? [];

        foreach ($sets as $set) {
            if (!isset($set['one'], $set['two'])) continue;

            $one = (int) $set['one'];
            $two = (int) $set['two'];

            if ($one < 0 || $two < 0 || $one > 99 || $two > 99) {
                $this->addError('sets', 'Cada juego debe estar entre 0 y 99.');
                return;
            }

            $diff = abs($one - $two);
            $max = max($one, $two);
            $min = min($one, $two);

            if ($max < 6 || ($max === 6 && $diff < 2)) {
                $this->addError('sets', 'Para ganar un set 6-x debe haber al menos 2 de diferencia.');
                return;
            }

            if ($max === 7 && !in_array($min, [5, 6])) {
                $this->addError('sets', 'Para ganar 7-x, el perdedor debe tener 5 o 6 juegos.');
                return;
            }

            if ($max > 7 && $diff < 2) {
                $this->addError('sets', 'En tie-breaks largos debe haber diferencia de 2 juegos.');
                return;
            }
        }

        $result = collect($sets)
            ->filter(fn($s) => isset($s['one'], $s['two']) && $s['one'] !== '' && $s['two'] !== '')
            ->map(fn($s) => $s['one'] . '-' . $s['two'])
            ->implode(',');

        $game->update(['result' => $result]);

        $winnerPosition = $this->determineWinner($game);
        if ($winnerPosition) {
            $this->updatePlayerStats($game, $winnerPosition);
            $this->advanceBracket($game, $winnerPosition);

            $bracket = $game->bracket;
            $loserPair = $winnerPosition === 1 ? $game->pairTwo : $game->pairOne;

            // ❌ No asignar puntos si pierde en primera ronda del principal
            $esPrimeraDelPrincipal = $bracket->type === 'principal' && $game->round_number === $bracket->games()->max('round_number');

            if (!$esPrimeraDelPrincipal) {
                $seguiraJugando = $bracket->games()
                    ->where('round_number', '<', $game->round_number)
                    ->where(function ($q) use ($loserPair) {
                        $q->where('pair_one_id', $loserPair->id)
                            ->orWhere('pair_two_id', $loserPair->id);
                    })->exists();

                if (!$seguiraJugando) {
                    $posicion = $game->round_number === 1 ? 2 : null; // 🥈 Subcampeón si es la final
                    $this->asignarPuntosAPareja($loserPair, $bracket, $game->round_number, $posicion);
                }
            }
        }

        // Paso a cuadro de consolación
        if (
            $game->bracket->type === 'principal' &&
            $game->round_number === $game->bracket->games()->max('round_number')
        ) {
            $loserPair = $winnerPosition === 1 ? $game->pairTwo : $game->pairOne;

            $consolationBracket = $game->bracket->tournament
                ->brackets()
                ->where('category_id', $game->bracket->category_id)
                ->where('type', 'consolacion')
                ->first();

            $targetGame = null;

            if ($consolationBracket) {
                if ($consolationBracket->games()->count() === 0) {
                    $totalPairs = $game->bracket->games()
                        ->where('round_number', $game->round_number)
                        ->count();

                    $nextPowerOfTwo = pow(2, ceil(log($totalPairs, 2)));
                    $totalRounds = log($nextPowerOfTwo, 2);
                    $gamesToCreate = [];

                    for ($r = $totalRounds; $r > 0; $r--) {
                        $gamesInRound = pow(2, $r - 1);
                        for ($i = 1; $i <= $gamesInRound; $i++) {
                            $gamesToCreate[] = [
                                'bracket_id' => $consolationBracket->id,
                                'round_number' => $r,
                                'game_number' => $i,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                    }

                    Game::insert($gamesToCreate);
                }

                $firstRound = $consolationBracket->games()->max('round_number');
                $targetGame = $consolationBracket->games()
                    ->where('round_number', $firstRound)
                    ->get()
                    ->first(fn($g) => is_null($g->pair_one_id) || is_null($g->pair_two_id));

                if ($targetGame) {
                    if (is_null($targetGame->pair_one_id)) {
                        $targetGame->pair_one_id = $loserPair->id;
                    } else {
                        $targetGame->pair_two_id = $loserPair->id;
                    }
                    $targetGame->save();
                    $this->tryAssignNextGame($consolationBracket, $firstRound, $targetGame->game_number);
                }
            }

            if (!$consolationBracket || !$targetGame) {
                $this->asignarPuntosAPareja($loserPair, $game->bracket, $game->round_number, 2);
            }
        }

        // 🏆 Ganadores del cuadro
        if ($game->round_number === 1 && $winnerPosition) {
            $winnerPair = $winnerPosition === 1 ? $game->pairOne : $game->pairTwo;

            $bracket = $game->bracket;
            $category = $bracket->category->category_name;
            $tipo = $bracket->type === 'principal' ? 'Principal' : 'Consolación';

            session()->flash('success', "🏆 ¡Ganadores del cuadro $category - $tipo: {$winnerPair->playerOne->name} y {$winnerPair->playerTwo->name}!");

            $this->asignarPuntosAPareja($winnerPair, $bracket, $game->round_number, 1);
        }
    }

    protected function advanceBracket(Game $game, int $winnerPosition): void
    {
        $bracket = $game->bracket;
        $currentRound = $game->round_number;
        $nextRound = $currentRound - 1;

        if ($nextRound < 1) return;

        $winnerPairId = $winnerPosition === 1 ? $game->pair_one_id : $game->pair_two_id;
        $nextGameNumber = ceil($game->game_number / 2);

        $nextGame = $bracket->games()
            ->where('round_number', $nextRound)
            ->where('game_number', $nextGameNumber)
            ->first();

        if (!$nextGame) return;

        if ($game->game_number % 2 === 1 && is_null($nextGame->pair_one_id)) {
            $nextGame->pair_one_id = $winnerPairId;
        } elseif ($game->game_number % 2 === 0 && is_null($nextGame->pair_two_id)) {
            $nextGame->pair_two_id = $winnerPairId;
        }

        $nextGame->save();
        $this->tryAssignNextGame($bracket, $nextRound, $nextGameNumber);
    }

    protected function tryAssignNextGame($bracket, $round, $gameNumber)
    {
        $nextGame = $bracket->games()
            ->where('round_number', $round)
            ->where('game_number', $gameNumber)
            ->first();

        if (!$nextGame || !$nextGame->pair_one_id || !$nextGame->pair_two_id || $nextGame->start_game_date) return;

        $slots = $bracket->tournament->slots;
        $courts = $bracket->tournament->venues()->with('courts')->get()->pluck('courts')->flatten();

        $pair1Slots = $nextGame->pairOne->unavailableSlots()->pluck('tournament_slot_id')->toArray();
        $pair2Slots = $nextGame->pairTwo->unavailableSlots()->pluck('tournament_slot_id')->toArray();

        $previousGames = Game::where(function ($q) use ($nextGame) {
            $q->where('pair_one_id', $nextGame->pair_one_id)
                ->orWhere('pair_two_id', $nextGame->pair_one_id)
                ->orWhere('pair_one_id', $nextGame->pair_two_id)
                ->orWhere('pair_two_id', $nextGame->pair_two_id);
        })->whereNotNull('start_game_date')->get();

        foreach ($slots as $slot) {
            $slotId = $slot->id;
            if (in_array($slotId, $pair1Slots) || in_array($slotId, $pair2Slots)) continue;

            $slotStart = $slot->slot_date . ' ' . $slot->start_time;
            $restOk = true;

            foreach ($previousGames as $pg) {
                $prevEnd = \Carbon\Carbon::parse($pg->end_game_date);
                $newStart = \Carbon\Carbon::parse($slotStart);
                if ($prevEnd->diffInHours($newStart, false) < 6) {
                    $restOk = false;
                    break;
                }
            }

            if (!$restOk) continue;

            foreach ($courts as $court) {
                $alreadyUsed = Game::where('court_id', $court->id)
                    ->where('start_game_date', $slotStart)
                    ->exists();

                if (!$alreadyUsed) {
                    $nextGame->update([
                        'start_game_date' => $slot->slot_date . ' ' . $slot->start_time,
                        'end_game_date' => $slot->slot_date . ' ' . $slot->end_time,
                        'court_id' => $court->id,
                        'venue_id' => $court->venue_id,
                    ]);
                    return;
                }
            }
        }
    }

    protected function determineWinner(Game $game): ?int
    {
        $sets = explode(',', $game->result);
        $score1 = $score2 = 0;

        foreach ($sets as $set) {
            [$g1, $g2] = array_map('trim', explode('-', trim($set)));
            if (!is_numeric($g1) || !is_numeric($g2)) continue;
            $g1 = (int) $g1;
            $g2 = (int) $g2;
            if ($g1 > $g2) $score1++;
            elseif ($g2 > $g1) $score2++;
        }

        return $score1 === $score2 ? null : ($score1 > $score2 ? 1 : 2);
    }

    protected function updatePlayerStats(Game $game, int $winnerPosition): void
    {
        $winnerPair = $winnerPosition === 1 ? $game->pairOne : $game->pairTwo;
        $loserPair  = $winnerPosition === 1 ? $game->pairTwo : $game->pairOne;

        foreach ([$winnerPair, $loserPair] as $pair) {
            if (!$pair) continue;

            foreach ($pair->players as $user) {
                $ranking = Ranking::firstOrCreate(['user_id' => $user->id]);
                $ranking->games_played += 1;

                if ($pair->id === $winnerPair->id) {
                    $ranking->games_won += 1;
                }

                $ranking->save();
            }
        }
    }


    protected function asignarPuntosAPareja(Pair $pair, Bracket $bracket, int $roundNumber, ?int $posicionForzada = null): void
    {
        $tournament = $bracket->tournament;
        $categoryName = $bracket->category->category_name;
        $type = $bracket->type;

        // Posición alcanzada: calcula correctamente usando la profundidad del cuadro
        $position = $posicionForzada ?? pow(2, $bracket->games()->max('round_number') - $roundNumber + 1);

        // Buscar puntos base
        $positionPoint = PositionPoint::where('category', $categoryName)
            ->where('type', $type)
            ->where('position', $position)
            ->first();

        if (!$positionPoint) return;

        $puntos = $positionPoint->base_points * $tournament->level;

        foreach ($pair->players as $user) {
            $ranking = Ranking::firstOrCreate(['user_id' => $user->id]);

            $ranking->points += $puntos;
            $ranking->games_played += 1;

            // Suma victoria si fue campeón (posición 1)
            if ($posicionForzada === 1) {
                $ranking->games_won += 1;
            }

            $ranking->save();
        }
    }



    public function render()
    {
        $this->tournament->load(
            'categories',
            'brackets.games.pairOne.playerOne',
            'brackets.games.pairOne.playerTwo',
            'brackets.games.pairTwo.playerOne',
            'brackets.games.pairTwo.playerTwo'
        );

        return view('livewire.bracket-viewer');
    }
}
