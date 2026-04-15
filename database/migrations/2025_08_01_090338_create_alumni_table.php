<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('idalumni');
            $table->string('nombre');
            $table->string('name');
            $table->string('tipo');
            $table->integer('tamanio')->nullable();
            $table->string('email');
            $table->string('empresa')->nullable();
            $table->string('posicion')->nullable();
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
