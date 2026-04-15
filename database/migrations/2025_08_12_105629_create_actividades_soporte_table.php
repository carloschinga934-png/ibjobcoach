<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_actividades_soporte_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadesSoporteTable extends Migration
{
    public function up()
    {
       // database/migrations/xxxx_xx_xx_xxxxxx_create_actividades_soporte_table.php

 Schema::create('actividad_soportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');  // Asegúrate de que sea unsignedBigInteger
            $table->unsignedBigInteger('usuario_id'); // Asegúrate de que sea unsignedBigInteger
            $table->text('actividad');
            $table->timestamps();

            // Claves foráneas
            $table->foreign('ticket_id')->references('id')->on('tickets_soporte')->onDelete('cascade');
            $table->foreign('usuario_id')->references('idusuario')->on('usuarios')->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::dropIfExists('actividades_soporte');
    }
}
