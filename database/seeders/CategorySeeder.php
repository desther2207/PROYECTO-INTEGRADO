<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Oro' => '#FFD700',
            'Plata' => '#C0C0C0',
            'Bronce' => '#CD7F32'
        ];
        
        foreach ($values as $category_name => $category_color) {
            Category::create(compact('category_name', 'category_color'));
        }        
    }
}
