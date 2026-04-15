<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('foro', function (Blueprint $t) {
            $t->unsignedBigInteger('categoria_id')->nullable()->after('autor');
            $t->unsignedBigInteger('empleado_id')->nullable()->after('categoria_id');
            $t->unsignedInteger('num_respuestas')->default(0)->after('vistas');
            $t->timestamp('last_activity_at')->nullable()->after('num_respuestas');
            $t->boolean('pinned')->default(false)->after('last_activity_at');
            $t->boolean('closed')->default(false)->after('pinned');
            $t->json('tags')->nullable()->after('closed');
            $t->softDeletes();

            // índices
            $t->index('fecha');
            $t->index('estado');
            $t->index('empleado_id');
            $t->index('categoria_id');
            $t->index('last_activity_at');
        });
    }

    public function down(): void
    {
        Schema::table('foro', function (Blueprint $t) {
            // quita índices (por columnas es lo más simple)
            $t->dropIndex(['fecha']);
            $t->dropIndex(['estado']);
            $t->dropIndex(['empleado_id']);
            $t->dropIndex(['categoria_id']);
            $t->dropIndex(['last_activity_at']);

            // quita columnas
            $t->dropSoftDeletes();
            $t->dropColumn(['categoria_id','empleado_id','num_respuestas','last_activity_at','pinned','closed','tags']);
        });
    }
};
