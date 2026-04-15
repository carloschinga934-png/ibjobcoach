<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id('idarticulo');
            $table->text('descripcion');
            $table->string('nombre');
            $table->string('tipo');
            $table->integer('tamanio')->nullable();
            $table->date('fechapublicacion')->nullable();
            $table->unsignedBigInteger('idcategoria');

            $table->foreign('idcategoria')->references('idcategoria')->on('categoriaarticulo')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
