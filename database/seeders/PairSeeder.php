<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parejas = Pair::factory(35)->create();
        $ids = Category::pluck('id')->toArray();
        foreach ($parejas as $pareja) {
            shuffle($ids);
            $pareja->categories()->attach($this->getRandomArrayIdTags($ids));
        }
    }
    private function getRandomArrayIdTags(array $ids): array
    {
        return array_slice($ids, 0, random_int(1, count($ids) - 1));
    }
}
