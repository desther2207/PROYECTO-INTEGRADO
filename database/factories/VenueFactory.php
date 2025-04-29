<?php

namespace Database\Factories;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'venue_name' => fake()->randomElement(['Pechina', 'Viator', 'Benahadux', 'Huercal']),
            'num_courts' => fake()->numberBetween(1, 10),
            'province_id' => Province::all()->random()->id,
            'address' => fake()->address(),
        ];
    }
}
