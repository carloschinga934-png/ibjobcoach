
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Quita FK + columna de una vez (Laravel 8.78+)
            $table->dropConstrainedForeignId('validado_por');

            $table->dropColumn([
                'pendiente_validacion',
                'estado',
                'validado_en',
                'observaciones_validacion',
            ]);
        });
    }
};