<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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
