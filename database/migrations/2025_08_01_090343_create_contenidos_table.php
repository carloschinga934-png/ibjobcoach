<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->id('idcontenido');
            $table->text('descripcion');
            $table->string('nombre');
            $table->string('url');
            $table->unsignedBigInteger('idcategoria');
            $table->date('fechapublicacion')->nullable();
            $table->timestamps();

            $table->foreign('idcategoria')
                ->references('idcategoria')
                ->on('categoriacontenido')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenidos');
    }
};
