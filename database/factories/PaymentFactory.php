<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'tournament_id' => Tournament::all()->random()->id,
            'payment_date' => fake()->dateTimeBetween('-1 week', 'now'),
            'amount' => fake()->randomFloat(2, 1, 100),
        ];
    }
}
