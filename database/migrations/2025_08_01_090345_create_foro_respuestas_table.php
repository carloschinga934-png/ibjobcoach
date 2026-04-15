<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('foro_respuestas', function (Blueprint $t) {
            $t->bigIncrements('idrespuestaforo');
            $t->unsignedBigInteger('foro_id');
            $t->unsignedBigInteger('usuario_id')->nullable();
            $t->string('nombre', 150)->nullable();
            $t->boolean('es_admin')->default(false);
            $t->text('mensaje');
            $t->timestamps();

            $t->foreign('foro_id')->references('idforo')->on('foro')->onDelete('cascade');
            $t->index(['foro_id','created_at']);
            $t->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foro_respuestas');
    }
};
