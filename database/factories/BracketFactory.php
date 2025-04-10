<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bracket>
 */
class BracketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => Tournament::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'status' => fake()->randomElement(['En curso', 'Finalizado']),
            'type' => fake()->randomElement(['principal', 'consolacion']),
        ];
    }
}
