<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosRehash extends Command
{
    protected $signature   = 'usuarios:rehash {--chunk=500}';
    protected $description = 'Convierte contraseñas de texto plano a Bcrypt';

    public function handle(): int
    {
        $pendientes = DB::table('usuarios')
                        ->where('password', 'not like', '$2%')
                        ->count();

        if ($pendientes === 0) {
            $this->info('No queda nada por convertir.');
            return self::SUCCESS;
        }

        $this->info("Procesando {$pendientes} registros…");
        $bar = $this->output->createProgressBar($pendientes);
        $bar->start();

        DB::table('usuarios')
        ->where('password', 'not like', '$2%')
        ->orderBy('idusuario')
        ->chunkById($this->option('chunk'), function ($users) use ($bar) {
            foreach ($users as $u) {
                DB::table('usuarios')
                    ->where('idusuario', $u->idusuario)
                    ->update([
                        'password' => Hash::make($u->password),
                        'token'    => null,
                    ]);
                $bar->advance();
            }
        }, 'idusuario');


        $bar->finish();
        $this->newLine(2);
        $this->info('✔ Contraseñas convertidas');
        return self::SUCCESS;
    }
}

