<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Bracket extends Model
{
    /** @use HasFactory<\Database\Factories\BracketFactory> */
    use HasFactory;

    protected $fillable = ['tournament_id', 'category_id', 'status', 'type'];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function getPairsFromBracket(Bracket $bracket)
    {
        return $bracket->category->pairs()
            ->where('tournament_id', $bracket->tournament_id)
            ->inRandomOrder()
            ->get();
    }

    // App\Models\Bracket.php

    public function generateGames()
    {
        Log::info('Entrando en generateGames');

        $this->games()->delete();

        $pairs = Pair::whereHas('categories', fn($q) =>
        $q->where('category_id', $this->category_id))
            ->where('tournament_id', $this->tournament_id)
            ->where('status', 'confirmada')
            ->whereNotNull('player_2_id')
            ->get()
            ->unique('id')
            ->shuffle()
            ->values();

        if ($pairs->count() < 3) return false;

        $totalPairs = $pairs->count();
        $nextPowerOfTwo = pow(2, ceil(log($totalPairs, 2)));
        $byes = $nextPowerOfTwo - $totalPairs;

        for ($i = 0; $i < $byes; $i++) {
            $pairs->push(null);
        }

        $totalRounds = log($nextPowerOfTwo, 2);
        $currentRound = $totalRounds;

        $slots = $this->tournament->slots;
        $courts = \App\Models\Court::whereIn('venue_id', $this->tournament->venues->pluck('id'))->get();
        $usedSlots = [];

        $currentPairs = $pairs;
        while ($currentRound > 0) {
            $gamesInRound = 0;
            $nextRoundPairs = collect();

            if ($currentPairs->count() % 2 !== 0) {
                $currentPairs->push(null);
            }

            for ($i = 0; $i < $currentPairs->count(); $i += 2) {
                $pair1 = $currentPairs[$i];
                $pair2 = $currentPairs[$i + 1];

                $pairOneId = $pair1?->id;
                $pairTwoId = $pair2?->id;
                $venueId = null;
                $courtId = null;
                $start = null;
                $end = null;

                if ($currentRound === $totalRounds && $pairOneId && $pairTwoId) {
                    
                    $bestSlot = null;
                    $minConflicts = PHP_INT_MAX;

                    foreach ($slots as $slot) {
                        $slotDate = $slot->slot_date;
                        $startTime = $slot->start_time;
                        $endTime = $slot->end_time;

                        foreach ($courts as $court) {
                            $datetimeKey = $court->id . '_' . $slotDate . '_' . $startTime;

                            if (in_array($datetimeKey, $usedSlots)) continue;

                            $conflicts = 0;

                            foreach ([$pairOneId, $pairTwoId] as $pid) {
                                $conflicts += PairUnavailableSlot::where('pair_id', $pid)
                                    ->whereHas('tournamentSlot', fn($q) =>
                                    $q->where('slot_date', $slotDate)
                                        ->where('start_time', $startTime))
                                    ->count();
                            }

                            if ($conflicts < $minConflicts) {
                                $minConflicts = $conflicts;
                                $bestSlot = [
                                    'court_id' => $court->id,
                                    'venue_id' => $court->venue_id,
                                    'start' => $slotDate . ' ' . $startTime,
                                    'end' => $slotDate . ' ' . $endTime,
                                    'key' => $datetimeKey
                                ];

                                if ($conflicts === 0) break 2;
                            }
                        }
                    }

                    if ($bestSlot) {
                        $courtId = $bestSlot['court_id'];
                        $venueId = $bestSlot['venue_id'];
                        $start = $bestSlot['start'];
                        $end = $bestSlot['end'];
                        $usedSlots[] = $bestSlot['key'];
                    }
                }

                \App\Models\Game::create([
                    'bracket_id' => $this->id,
                    'pair_one_id' => $pairOneId,
                    'pair_two_id' => $pairTwoId,
                    'venue_id' => $venueId,
                    'court_id' => $courtId,
                    'start_game_date' => $start,
                    'end_game_date' => $end,
                    'result' => null,
                    'game_number' => ++$gamesInRound,
                    'round_number' => $currentRound,
                ]);

                // Para las siguientes rondas
                if ($pair1 && !$pair2) {
                    $nextRoundPairs->push($pair1);
                } elseif (!$pair1 && $pair2) {
                    $nextRoundPairs->push($pair2);
                } else {
                    $nextRoundPairs->push(null);
                }
            }

            $currentPairs = $nextRoundPairs;
            $currentRound--;
        }
        return true;
    }
}
