<?php

namespace Database\Seeders;

use App\Models\Bracket;
use App\Models\Court;
use App\Models\Game;
use App\Models\Pair;
use App\Models\Payment;
use App\Models\Tournament;
use App\Models\User;
use App\Models\Venue;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        
        $this->call(ProvinceSeeder::class);

        Venue::factory(10)->create();

        $this->call(CategorySeeder::class);

        Court::factory(10)->create();

        Storage::deleteDirectory('images/tournaments');
        Storage::deleteDirectory('images/tournaments/carteles');

        Storage::makeDirectory('images/tournaments');
        Storage::makeDirectory('images/tournaments/carteles');

        
        $this->call(TournamentSeeder::class);

        $this->call(PairSeeder::class);


        Bracket::factory(10)->create();
        Game::factory(10)->create();
        Payment::factory(10)->create();
    }
}
