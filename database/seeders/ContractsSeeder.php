<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contract::create([
            'name' => 'Gratuito',
            'type' => 1,
            'description' => json_encode([
                'duration' => 'Ilimitado', 
                'features' => ['Crear, editar, listar y borrar planes propios', 'Categorizar planes', 'Compartir planes con otros usuarios', 'Asignar informes compartidos a categorías propias', 'Escribir y gestionar comentarios y valoraciones de espacios culturales', 'Seguir un listado de municipios', 'Establecer espacios culturales favoritos', 'Abrir tiquetes de consulta', 'Recibir respuestas de administradores a través de tiquetes']]),
            'price' => 0,
            'contract_description' => 'Hola'
        ]);

        Contract::create([
            'name' => 'Premium',
            'type' => 2,
            'description' => json_encode([
                'duration' => 'Mensual', 
                'features' => ['Crear, editar, listar y borrar planes propios', 'Categorizar planes', 'Compartir planes con otros usuarios', 'Asignar informes compartidos a categorías propias', 'Escribir y gestionar comentarios y valoraciones de espacios culturales', 'Seguir un listado de municipios', 'Establecer espacios culturales favoritos', 'Abrir tiquetes de consulta', 'Recibir respuestas de administradores a través de tiquetes', 'Crear planes públicos', 'Utilizar la API', 'Consultar comentarios', 'Establecer límites de consultas por minuto']]),
            'price' => 19.99,
            'contract_description' => 'Hola'
        ]);
    }
}
