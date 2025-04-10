<?php

namespace Database\Factories;

use App\Models\Bracket;
use App\Models\Court;
use App\Models\Pair;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('+1 days', '+1 month');
        $end = (clone $start)->modify('+1 hour');
        
        return [
            'bracket_id' => Bracket::all()->random()->id,
            'pair_one_id' => Pair::all()->random()->id,
            'pair_two_id' => Pair::all()->random()->id,
            'court_id' => Court::all()->random()->id,
            'venue_id' => Venue::all()->random()->id,
            'start_game_date' => $start,
            'end_game_date' => $end,
            'result' => fake()->sentence(),
        ];
    }
}
