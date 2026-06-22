<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // La tabla existente tiene estructura antigua (clave/valor). Se reemplaza por la
        // estructura del nuevo repo que usa tipo_documento/nombre_parametro/categoria.
        Schema::dropIfExists('parametros_control');

        Schema::create('parametros_control', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_documento', ['cedula', 'licencia']);
            $table->string('nombre_parametro');
            $table->enum('categoria', ['campo_requerido', 'vigencia', 'formato', 'coherencia']);
            $table->boolean('es_bloqueante')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametros_control');
    }
};
