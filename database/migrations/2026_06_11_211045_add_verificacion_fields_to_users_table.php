<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('email');
            $table->date('fecha_nacimiento')->nullable()->after('telefono');
            $table->string('numero_carnet', 20)->nullable()->after('fecha_nacimiento');
            $table->string('carnet_anverso_path')->nullable()->after('numero_carnet');
            $table->string('carnet_reverso_path')->nullable()->after('carnet_anverso_path');
            $table->enum('estado_verificacion', ['pendiente','analizando','verificada','rechazada'])
                  ->default('pendiente')->after('carnet_reverso_path');
            $table->json('resultado_analisis')->nullable()->after('estado_verificacion');
            $table->timestamp('analizado_en')->nullable()->after('resultado_analisis');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telefono','fecha_nacimiento','numero_carnet',
                'carnet_anverso_path','carnet_reverso_path',
                'estado_verificacion','resultado_analisis','analizado_en',
            ]);
        });
    }
};