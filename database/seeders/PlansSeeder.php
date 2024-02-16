<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'title' => 'Explorando la Barcelona Modernista',
            'description' => 'Descubre la arquitectura modernista de Barcelona a través de un recorrido fascinante por sus famosos edificios diseñados por Gaudí y otros arquitectos destacados. Experimenta la rica historia cultural de la ciudad.',
            'image' => 'images/cinema.jpg',
            'status' => 1,
            'start_date' => now(),
            'end_date' => now()->addWeek(),
            'id_user' => 1,
        ]);

        Plan::create([
            'title' => 'Sabores de Barcelona: Ruta Gastronómica',
            'description' => 'Sumérgete en la escena culinaria de Barcelona con esta ruta gastronómica. Disfruta de tapas auténticas, platos catalanes tradicionales y experiencias culinarias únicas. Descubre los secretos de la cocina local.',
            'image' => 'images/cinema.jpg',
            'status' => 1,
            'start_date' => now(),
            'end_date' => now()->addWeek(),
            'id_user' => 1,
        ]);

    }
}
