<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaArticuloSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['idcategoria' => 1,  'nombre' => 'Técnicas de entrevista'],
            ['idcategoria' => 2,  'nombre' => 'Sesiones Outplacement'],
            ['idcategoria' => 3,  'nombre' => 'Etapas de Ejecución'],
            ['idcategoria' => 4,  'nombre' => 'Marketing Personal'],
            ['idcategoria' => 5,  'nombre' => 'Networking'],
            ['idcategoria' => 6,  'nombre' => 'Emprendimeinto'],
            ['idcategoria' => 7,  'nombre' => 'Primer Trabajo'],
            ['idcategoria' => 8,  'nombre' => 'Biblioteca'],
            ['idcategoria' => 9,  'nombre' => 'Templates'],
            ['idcategoria' => 10, 'nombre' => 'CV'],
            ['idcategoria' => 11, 'nombre' => 'Match de Mercado'],
            ['idcategoria' => 12, 'nombre' => 'Propuestas de Valor'],
            ['idcategoria' => 13, 'nombre' => 'Contenido Linkedin'],
            ['idcategoria' => 14, 'nombre' => 'Casa Procesos'],
            ['idcategoria' => 15, 'nombre' => 'Conocimiento Personal'],
        ];

        foreach ($rows as $r) {
            DB::table('categoriaarticulo')->updateOrInsert(
                ['idcategoria' => $r['idcategoria']],
                ['nombre' => $r['nombre']]
            );
        }
    }
}
