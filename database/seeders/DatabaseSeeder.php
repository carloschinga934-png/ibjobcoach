<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Llama primero a los seeders de catálogos/base
        $this->call([
            RoleSeeder::class,
            CategoriaContenidoSeeder::class,
            CategoriaArticuloSeeder::class,
            PosicionesSeeder::class,
        ]);


        
        Usuario::create([
            'nombre' => 'Administrador',
            'apellido' => 'Principal',
            'correo' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Siempre hasheada
            'role_id' => 1, // admin
            'status' => 'activo',
        ]);
           // Usuario empleado
        Usuario::create([
            'nombre' => 'Empleado',
            'apellido' => 'Ejemplo',
            'correo' => 'empleado@example.com',
            'password' => Hash::make('empleado123'),
            'role_id' => 2, // asumiendo 2 = empleado
            'status' => 'activo',
        ]);

        // Usuario normal
        Usuario::create([
            'nombre' => 'Usuario',
            'apellido' => 'Regular',
            'correo' => 'usuario@example.com',
            'password' => Hash::make('usuario123'),
            'role_id' => 3, // asumiendo 3 = usuario normal
            'status' => 'activo',
        ]);
    }
}
