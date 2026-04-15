<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categoriacontenido', function (Blueprint $table) {
            $table->id('idcategoria');           // BIGINT UNSIGNED AUTO_INCREMENT
            $table->string('nombre');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoriacontenido');
    }
};
