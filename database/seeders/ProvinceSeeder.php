<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Almería' => '#FFD700',
            'Cádiz' => '#FF6347',
            'Córdoba' => '#4682B4',
            'Granada' => '#32CD32',
            'Huelva' => '#FF4500',
            'Jaén' => '#8A2BE2',
            'Málaga' => '#FF69B4',
            'Sevilla' => '#FF8C00',
            'Ceuta' => '#7FFF00',
            'Melilla' => '#00CED1',
            'Madrid' => '#FF1493',
            'Barcelona' => '#00BFFF',
            'Valencia' => '#ADFF2F',
            'Alicante' => '#FF00FF',
            'Castellón' => '#FF7F50',
            'Murcia' => '#FFB6C1',
            'Toledo' => '#FF4500',
            'Albacete' => '#00FF7F',
            'Ciudad Real' => '#FFD700',
            'Cuenca' => '#FF6347',
            'Guadalajara' => '#4682B4',
            'Soria' => '#32CD32',
            'Segovia' => '#FF4500',
            'Ávila' => '#8A2BE2',
            'Burgos' => '#FF69B4',
            'La Rioja' => '#FF8C00',
            'Navarra' => '#7FFF00',
            'Zaragoza' => '#00CED1',
            'Huesca' => '#FF1493',
            'Lérida' => '#00BFFF',
            'Gerona' => '#ADFF2F',
            'Tarragona' => '#FF00FF',
            'Asturias' => '#FF7F50',
            'Cantabria' => '#FFB6C1',
            'País Vasco' => '#FF4500',
            'Guipúzcoa' => '#00FF7F',
            'Álava' => '#FFD700',
            'Vizcaya' => '#FF6347',
            'Castilla y León' => '#4682B4',
            'Castilla-La Mancha' => '#32CD32',
            'Extremadura' => '#FF4500',
            'Galicia' => '#8A2BE2',
            'La Coruña' => '#FF69B4',
            'Lugo' => '#FF8C00',
            'Orense' => '#7FFF00',
            'Pontevedra' => '#00CED1',
            'Islas Baleares' => '#FF1493',
            'Islas Canarias' => '#00BFFF',
            'Tenerife' => '#ADFF2F',
            'Gran Canaria' => '#FF00FF',
            'Lanzarote' => '#FF7F50',
            'Fuerteventura' => '#FFB6C1',
            'La Palma' => '#FF4500',
            'La Gomera' => '#00FF7F',
            'El Hierro' => '#FFD700',
            'Ceuta' => '#FF6347',
            'Melilla' => '#4682B4',
            'Andalucía' => '#32CD32',
            'Cataluña' => '#FF4500',
            'Comunidad Valenciana' => '#8A2BE2',
            'Aragón' => '#FF69B4',
            'Asturias' => '#FF8C00',
        ];
        
        foreach ($values as $province_name => $color) {
            Province::create(compact('province_name', 'color'));
        }        
    }
}
