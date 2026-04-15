<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->boolean('pendiente_validacion')->default(true)->index();
            $table->string('estado')->default('abierto')->index();
            $table->foreignId('validado_por')->nullable()->constrained('users');
            $table->timestamp('validado_en')->nullable();
            $table->text('observaciones_validacion')->nullable();
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