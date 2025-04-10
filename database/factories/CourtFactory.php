<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Court>
 */
class CourtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'venue_id' => Venue::all()->random()->id,
            'nombre' => fake()->randomElement(['Pista 1', 'Pista 2', 'Pista 3']),
            'info' => fake()->sentence(3),
        ];
    }
}
