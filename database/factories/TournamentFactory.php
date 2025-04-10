<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));

        // Genera la fecha de inicio
        $start = fake()->dateTimeBetween('-1 month', 'now');
        // Genera la fecha de fin a partir de la fecha de inicio (por ejemplo, hasta 1 mes después)
        $end = fake()->dateTimeBetween($start, '+1 month');

        return [
            'tournament_image'=>'images/tournaments/'.fake()->picsum('public/storage/images/tournaments', 640,  480, false),
            'cartel'=>'images/tournaments/carteles/'.fake()->picsum('public/storage/images/tournaments/carteles', 480,  640, false),
            'tournament_name' => fake()->sentence(4),
            'description' => fake()->text(),
            'incription_price' => fake()->randomFloat(2, 1, 999),
            'level' => fake()->randomElement(['primera', 'segunda', 'tercera', 'cuarta']),
            'status' => fake()->randomElement(['inscripcion', 'en curso', 'finalizado']),
            'inscription_start_date' => $start->format('Y-m-d'),
            'inscription_end_date' => $end->format('Y-m-d'),
            'start_date' => $start->format('Y-m-d'),
            'end_date' =>  $end->format('Y-m-d'),
            'max_pairs' => fake()->randomDigit(),
            'current_pairs' => fake()->randomDigit(),
        ];
    }
}
