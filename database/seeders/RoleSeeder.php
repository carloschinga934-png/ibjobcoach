<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::insert([
            ['id' => 1, 'nombre' => 'admin'],
            ['id' => 2, 'nombre' => 'empleado'],
            ['id' => 3, 'nombre' => 'usuario'],
        ]);
    }
}
