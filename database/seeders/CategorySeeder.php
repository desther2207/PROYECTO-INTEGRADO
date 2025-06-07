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
        $categoriasConColores = [
            // Masculinas
            'Primera Masculina' => '#FFD700',  // Dorado - nivel más alto
            'Segunda Masculina' => '#C0C0C0',  // Plata
            'Tercera Masculina' => '#CD7F32',  // Bronce
            'Cuarta Masculina' => '#A0522D',   // Marrón fuerte
            'Quinta Masculina' => '#8B4513',   // Marrón oscuro

            // Femeninas
            'Primera Femenina' => '#FF69B4',   // Rosa fuerte
            'Segunda Femenina' => '#FFB6C1',   // Rosa claro
            'Tercera Femenina' => '#FFC0CB',   // Rosado pálido
            'Cuarta Femenina' => '#FFA07A',    // Salmón
            'Femenino B' => '#F08080',         // Coral claro

            // Mixtas
            'Mixto A' => '#FF8C00',            // Naranja oscuro
            'Mixto B' => '#FFA500',            // Naranja medio
            'Mixto C' => '#FFDAB9',            // Melocotón claro

            // +40 / Senior
            '+40 Masculina' => '#4682B4',      // Azul acero
            '+40 Femenina' => '#DB7093',       // Rosa viejo
            'Mixto +45' => '#DAA520',          // Oro oscuro
        ];

        foreach ($categoriasConColores as $nombre => $color) {
            Category::firstOrCreate(
                ['category_name' => $nombre],
                ['category_color' => $color]
            );
        }
    }
}
