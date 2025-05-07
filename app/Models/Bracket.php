<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        // Eliminar juegos anteriores (opcional, para pruebas limpias)
        $this->games()->delete();

        // 1️⃣ Obtener parejas inscritas en esta categoría
        $pairs = $this->category->pairs()
            ->where('status', 'confirmada')
            ->whereNotNull('player_2_id')
            ->get()
            ->unique('id')
            ->shuffle()
            ->values();


        // Si hay menos de 3 parejas → NO generamos
        if ($pairs->count() < 3) {
            return false;
        }

        // 2️⃣ Añadir BYEs si es necesario
        $totalPairs = $pairs->count();
        $nextPowerOfTwo = pow(2, ceil(log($totalPairs) / log(2)));
        $byes = $nextPowerOfTwo - $totalPairs;

        for ($i = 0; $i < $byes; $i++) {
            $pairs->push(null);
        }

        // 3️⃣ Emparejar para la PRIMERA RONDA
        $slots = $this->tournament->slots;
        $pistas = \App\Models\Court::all();

        $gameNumber = 1;

        for ($i = 0; $i < $pairs->count(); $i += 2) {

            $pair1 = $pairs[$i];
            $pair2 = $pairs[$i + 1];

            // Si hay BYE → no se crea partido, pasa de ronda (en el futuro)
            if ($pair1 && !$pair2) {
                continue;
            }

            if (!$pair1 && $pair2) {
                continue;
            }

            // 4️⃣ Buscar slot disponible (sin conflictos)
            $pair1Available = $pair1?->unavailableSlots ? $slots->whereNotIn('id', $pair1->unavailableSlots->pluck('tournament_slot_id'))->pluck('id')->toArray() : $slots->pluck('id')->toArray();
            $pair2Available = $pair2?->unavailableSlots ? $slots->whereNotIn('id', $pair2->unavailableSlots->pluck('tournament_slot_id'))->pluck('id')->toArray() : $slots->pluck('id')->toArray();

            $commonSlots = array_intersect($pair1Available, $pair2Available);

            if (empty($commonSlots)) {
                $slotId = $slots->random()->id;
            } else {
                $slotId = $commonSlots[array_rand($commonSlots)];
            }

            $slot = $slots->firstWhere('id', $slotId);

            // Buscar pista disponible
            $availableCourt = null;

            foreach ($pistas as $court) {
                $exists = \App\Models\Game::where('court_id', $court->id)
                    ->where('start_game_date', $slot->slot_date . ' ' . $slot->start_time)
                    ->exists();

                if (!$exists) {
                    $availableCourt = $court;
                    break;
                }
            }

            $courtId = $availableCourt?->id;
            $venueId = $availableCourt?->venue_id;

            // 5️⃣ Crear partido
            \App\Models\Game::create([
                'bracket_id' => $this->id,
                'pair_one_id' => $pair1->id,
                'pair_two_id' => $pair2->id,
                'venue_id' => $venueId,
                'court_id' => $courtId,
                'start_game_date' => $slot->slot_date . ' ' . $slot->start_time,
                'end_game_date' => $slot->slot_date . ' ' . $slot->end_time,
                'result' => '', // pendiente
                'game_number' => $gameNumber++,
            ]);
        }
    }
}
