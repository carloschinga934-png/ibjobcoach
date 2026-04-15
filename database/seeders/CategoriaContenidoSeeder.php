<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaContenidoSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['idcategoria' => 1,  'nombre' => 'Biblioteca'],
            ['idcategoria' => 2,  'nombre' => 'Empresa por industria'],
            ['idcategoria' => 3,  'nombre' => 'Contenidos Linkedin'],
            ['idcategoria' => 4,  'nombre' => 'cv'],
            ['idcategoria' => 5,  'nombre' => 'Match de mercado'],
            ['idcategoria' => 6,  'nombre' => 'Propuestas de valor'],
            ['idcategoria' => 7,  'nombre' => 'Técnicas de Entrevista'],
            ['idcategoria' => 8,  'nombre' => 'Templates'],
            ['idcategoria' => 9,  'nombre' => 'Videos de Programa'],
            ['idcategoria' => 10, 'nombre' => 'Cursos online'],
            ['idcategoria' => 11, 'nombre' => 'Películas y libros'],
            ['idcategoria' => 12, 'nombre' => 'Job Boards'],
            ['idcategoria' => 13, 'nombre' => 'Prospección de redes'],
            ['idcategoria' => 14, 'nombre' => 'Conocimiento personal'],
            ['idcategoria' => 15, 'nombre' => 'Lista de coworkings'],
            ['idcategoria' => 16, 'nombre' => 'Emprendimiento'],
            ['idcategoria' => 17, 'nombre' => 'Primer trabajo'],
            ['idcategoria' => 18, 'nombre' => 'Tendencias laborales'],
            ['idcategoria' => 19, 'nombre' => 'Joven Emprendor'],
            ['idcategoria' => 20, 'nombre' => 'Nuevas tendencias laborales'],
        ];

        foreach ($rows as $r) {
            DB::table('categoriacontenido')->updateOrInsert(
                ['idcategoria' => $r['idcategoria']],
                ['nombre' => $r['nombre']]
            );
        }
    }
}
