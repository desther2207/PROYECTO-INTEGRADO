<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositionPoint;

class PositionPointsSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Primera Masculina',
            'Segunda Masculina',
            'Tercera Masculina',
            'Cuarta Masculina',
            'Quinta Masculina',
            'Primera Femenina',
            'Segunda Femenina',
            'Tercera Femenina',
            'Cuarta Femenina',
            'Femenino B',
            'Mixto A',
            'Mixto B',
            'Mixto C',
            '+40 Masculina',
            '+40 Femenina',
            'Mixto +45',
        ];

        $puntos = [
            'principal' => [
                1 => 100,
                2 => 60,
                4 => 30,
                8 => 15,
            ],
            'consolacion' => [
                1 => 40,
                2 => 20,
            ],
        ];

        foreach ($categorias as $categoria) {
            // Puedes personalizar los puntos según la categoría aquí si lo necesitas
            foreach ($puntos as $type => $positions) {
                foreach ($positions as $position => $points) {
                    PositionPoint::create([
                        'category' => $categoria,
                        'type' => $type,
                        'position' => $position,
                        'base_points' => $points,
                    ]);
                }
            }
        }
    }
}
