<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activitat;

class ActivitatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activitat::create([
            'name' => 'Visita al Parc Güell',
            'description' => 'Experimenta la belleza de la arquitectura modernista de Antoni Gaudí en el famoso Parc Güell. Disfruta de una visita guiada llena de historia y arte.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 1,
        ]);

        Activitat::create([
            'name' => 'Tour Gastronómico en el Barrio Gótico',
            'description' => 'Embárcate en un viaje culinario por el encantador Barrio Gótico de Barcelona. Descubre los sabores locales en esta experiencia gastronómica única.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 2,
        ]);

        Activitat::create([
            'name' => 'Exploración del Museo Picasso',
            'description' => 'Sumérgete en el arte y la creatividad en el Museo Picasso. Descubre las obras maestras del famoso pintor español y aprende sobre su impacto en la historia del arte.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 1,
        ]);

        Activitat::create([
            'name' => 'Paseo en Velero por la Costa de Barcelona',
            'description' => 'Disfruta de la brisa marina y las impresionantes vistas de la costa de Barcelona en un relajante paseo en velero. Una experiencia inolvidable en el Mediterráneo.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 2,
        ]);

        Activitat::create([
            'name' => 'Espectáculo de Flamenco en El Raval',
            'description' => 'Vive la pasión y la emoción del flamenco en un espectáculo en vivo en el vibrante barrio de El Raval. Experimenta la autenticidad de esta expresión artística española.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 1,
        ]);

        Activitat::create([
            'name' => 'Cata de Vinos en una Bodega Catalana',
            'description' => 'Descubre los sabores de los vinos catalanes en una auténtica bodega. Disfruta de una cata guiada de vinos locales acompañada de deliciosos aperitivos.',
            'person_count' => 1,
            'id_user' => 1,
            'id_plan' => 2,
        ]);

    }
}
