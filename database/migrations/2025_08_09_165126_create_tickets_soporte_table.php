<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets_soporte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Cliente que reporta
            $table->unsignedBigInteger('asignado_a')->nullable(); // Empleado asignado
            $table->string('numero_ticket', 20)->unique(); // TS-2024-0001
            $table->string('titulo', 200);
            $table->text('descripcion');
            $table->enum('prioridad', ['baja', 'normal', 'alta', 'urgente'])->default('normal');
            $table->enum('categoria', ['tecnico', 'comercial', 'facturacion', 'general'])->default('general');
            $table->enum('estado', ['abierto', 'en_progreso', 'esperando_cliente', 'resuelto', 'cerrado'])->default('abierto');
            $table->timestamp('fecha_limite')->nullable();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->text('solucion')->nullable();
            $table->integer('calificacion')->nullable(); // 1-5 estrellas
            $table->text('comentario_calificacion')->nullable();
            $table->decimal('tiempo_resolucion', 8, 2)->nullable(); // Horas
            $table->boolean('validado')->default(false); // Para validar la atención
            $table->unsignedBigInteger('validado_por')->nullable(); // Quien validó
            $table->timestamp('fecha_validacion')->nullable();
            $table->text('observaciones_validacion')->nullable();
            $table->timestamps();

            // Índices
            $table->index(['usuario_id', 'estado']);
            $table->index(['asignado_a', 'estado']);
            $table->index(['categoria', 'prioridad']);
            $table->index('numero_ticket');

            // Claves foráneas
            $table->foreign('usuario_id')
                  ->references('idusuario')
                  ->on('usuarios')
                  ->onDelete('cascade');
                  
            $table->foreign('asignado_a')
                  ->references('idusuario')
                  ->on('usuarios')
                  ->onDelete('set null');
                  
            $table->foreign('validado_por')
                  ->references('idusuario')
                  ->on('usuarios')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets_soporte');
    }
};
