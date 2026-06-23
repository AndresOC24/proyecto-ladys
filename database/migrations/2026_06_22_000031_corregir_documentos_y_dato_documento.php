<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Eliminar dato_documento (depende de documentos) ──────────────
        // Fue creada por la migración 000030 pero con FK al documentos viejo.
        Schema::dropIfExists('dato_documento');

        // ── 2. Eliminar documentos viejo (tiene schema incorrecto: tipo, ruta_archivo, hash_archivo) ──
        // Primero hay que quitar su FK hacia registros_verificacion (tabla plural del proyecto original)
        if (Schema::hasTable('documentos')) {
            Schema::table('documentos', function (Blueprint $table) {
                // Quitar FKs que puedan impedir el DROP
                try {
                    $table->dropForeign(['registro_verificacion_id']);
                } catch (\Throwable $e) { /* puede no existir */ }
            });
            Schema::dropIfExists('documentos');
        }

        // ── 3. Crear documentos con el schema correcto del proyecto de grado ──
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_id')->constrained('registro_verificacion')->cascadeOnDelete();
            $table->enum('tipo_documento', ['cedula_anverso', 'cedula_reverso', 'licencia', 'soat', 'crpva']);
            $table->string('ruta_imagen');
            $table->boolean('calidad_legible')->nullable();
            $table->timestamps();
        });

        // ── 4. Recrear dato_documento con FK al documentos correcto ─────────
        Schema::create('dato_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete();
            $table->string('nombre_campo');
            $table->text('valor_extraido')->nullable();
            $table->timestamps();

            $table->index(['documento_id', 'nombre_campo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dato_documento');
        Schema::dropIfExists('documentos');
    }
};
