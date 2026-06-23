<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Resolver duplicados antes de agregar el índice unique.
        //    Si dos usuarios tienen el mismo carnet, el más reciente (ID mayor)
        //    queda con numero_carnet = NULL para no bloquear el sistema.
        //    El admin puede corregir el dato desde el panel.
        $duplicados = DB::table('users')
            ->select('numero_carnet', DB::raw('MAX(id) as id_nuevo'))
            ->whereNotNull('numero_carnet')
            ->groupBy('numero_carnet')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicados as $dup) {
            DB::table('users')
                ->where('id', $dup->id_nuevo)
                ->update(['numero_carnet' => null]);
        }

        // 2. Agregar índice unique (permite múltiples NULL, que es el comportamiento
        //    correcto para registros sin carnet verificado aún).
        Schema::table('users', function (Blueprint $table) {
            $table->unique('numero_carnet', 'users_numero_carnet_unique');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_numero_carnet_unique');
        });
    }
};
