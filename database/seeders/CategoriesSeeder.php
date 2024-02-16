<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Arquitectura']);
        Category::create(['name' => 'Gastronomía']);
        Category::create(['name' => 'Arte y Cultura']);
        Category::create(['name' => 'Aventura']);
        Category::create(['name' => 'Relax']);
        Category::create(['name' => 'Deporte']);
        Category::create(['name' => 'Historia']);
        Category::create(['name' => 'Naturaleza']);
        Category::create(['name' => 'Música']);
        Category::create(['name' => 'Cine']);
        Category::create(['name' => 'Tecnología']);
        Category::create(['name' => 'Moda']);
        Category::create(['name' => 'Ciencia']);
        Category::create(['name' => 'Literatura']);
        Category::create(['name' => 'Viajes']);
        Category::create(['name' => 'Fotografía']);
        Category::create(['name' => 'Animales']);
        Category::create(['name' => 'Cocina']);
        Category::create(['name' => 'Comedia']);
    }
}
