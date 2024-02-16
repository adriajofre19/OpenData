<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryCenter;

class CategoriesCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryCenter::create([
            'name' => 'Cines',
            'description' => 'Explora los diferentes cines de la ciudad de Barcelona',
            'image' => 'images/cinema.jpg'
        ]);

        CategoryCenter::create([
            'name' => 'Museos',
            'description' => 'Explora los diferentes museos de la ciudad de Barcelona',
            'image' => 'images/museo.jpg',
        ]);

        CategoryCenter::create([
            'name' => 'Auditorios',
            'description' => 'Explora los diferentes auditorios de la ciudad de Barcelona',
            'image' => 'images/auditorio.jpg'
        ]);

        CategoryCenter::create([
            'name' => 'Actividades culturales',
            'description' => 'Explora las diferentes actividades culturales de la ciudad de Barcelona',
            'image' => 'images/actividad.jpg'
        ]);
    }
}
