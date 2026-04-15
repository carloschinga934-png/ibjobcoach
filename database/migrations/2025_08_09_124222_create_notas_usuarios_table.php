<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notas_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // ID del usuario sobre quien es la nota
            $table->unsignedBigInteger('autor_id');   // ID del usuario que escribe la nota
            $table->string('titulo', 200);
            $table->text('contenido');
            $table->enum('tipo', ['info', 'importante', 'seguimiento', 'problema', 'resuelto'])
                  ->default('info');
            $table->boolean('es_privada')->default(false); // Para notas privadas
            $table->timestamps();

            // Índices y relaciones
            $table->index(['usuario_id', 'created_at']);
            $table->index(['autor_id']);
            $table->index(['tipo']);
            
            // Claves foráneas
            $table->foreign('usuario_id')
                  ->references('idusuario')
                  ->on('usuarios')
                  ->onDelete('cascade');
                  
            $table->foreign('autor_id')
                  ->references('idusuario') 
                  ->on('usuarios')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notas_usuarios');
    }
};