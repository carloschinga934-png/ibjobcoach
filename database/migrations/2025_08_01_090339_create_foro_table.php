<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foro', function (Blueprint $table) {
            $table->id('idforo');
            $table->string('autor');
            $table->string('foto')->nullable();
            $table->string('tipo');
            $table->integer('tamanio')->nullable();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('estado')->nullable();
            $table->integer('vistas')->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foro');
    }
};
