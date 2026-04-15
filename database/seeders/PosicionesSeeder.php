<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosicionesSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['id' => 1, 'nombre' => 'Operarios o Técnicos',      'valor' => '2.200'],
            ['id' => 2, 'nombre' => 'Analista o Especialista',   'valor' => '4.000'],
            ['id' => 3, 'nombre' => 'Jefe',                      'valor' => '6.600'],
            ['id' => 4, 'nombre' => 'Subgerente',                'valor' => '9.800'],
            ['id' => 5, 'nombre' => 'Gerente',                   'valor' => '14.000'],
        ];

        foreach ($rows as $r) {
            DB::table('posiciones')->updateOrInsert(
                ['id' => $r['id']],
                ['nombre' => $r['nombre'], 'valor' => $r['valor']]
            );
        }
    }
}
