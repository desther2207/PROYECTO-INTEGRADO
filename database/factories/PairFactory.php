<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pair>
 */
class PairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id'=>Tournament::all()->random()->id,
            'status'=>fake()->randomElement(['pendiente', 'confirmada']),
            'paid'=>fake()->boolean(),
            'player_1_id'=>User::all()->random()->id,
            'player_2_id'=>User::all()->random()->id,
            'invite_code'=>Str::random(32),
        ];
    }
}
