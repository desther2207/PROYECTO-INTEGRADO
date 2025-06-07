<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ranking;

class RankingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Ranking::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'games_played' => 0,
                    'games_won' => 0,
                ]
            );
        }
    }
}

