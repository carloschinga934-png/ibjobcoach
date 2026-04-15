<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->bigIncrements('idebook'); // si prefieres "id", usa $table->id();
            $table->string('titulo', 255);
            $table->date('fecha');
            $table->string('autor', 255);
            $table->decimal('precio', 10, 2)->default(0);
            $table->string('archivo', 512); // ruta al PDF en storage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};