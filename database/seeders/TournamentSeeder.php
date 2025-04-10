<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tournament;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            /**
     * Run the database seeds.
     */
        $torneos=Tournament::factory(15)->create();
        $ids=User::pluck('id')->toArray();
        foreach($torneos as $torneo){
            shuffle($ids);
            $torneo->organizers()->attach($this->getRandomArrayIdTags($ids));
        }

        $ids=Venue::pluck('id')->toArray();
        foreach($torneos as $torneo){
            shuffle($ids);
            $torneo->venues()->attach($this->getRandomArrayIdTags($ids));
        }

        $ids=Category::pluck('id')->toArray();
        foreach($torneos as $torneo){
            shuffle($ids);
            $torneo->categories()->attach($this->getRandomArrayIdTags($ids));
        }
    }
    private function getRandomArrayIdTags(array $ids):array{
       return array_slice($ids, 0, random_int(1, count($ids)-1));
    }
    }

