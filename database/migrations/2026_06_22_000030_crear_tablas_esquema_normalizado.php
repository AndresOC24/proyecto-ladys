<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── registro_verificacion ───────────────────────────────────────────
        if (! Schema::hasTable('registro_verificacion')) {
            Schema::create('registro_verificacion', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->enum('tipo_registro', ['pasajera', 'conductora']);
                $table->string('ruta_selfie')->nullable();
                $table->enum('estado_resultado', ['pendiente', 'aprobado', 'rechazado', 'observado', 'analizando'])
                      ->default('pendiente');
                $table->timestamps();

                $table->index(['user_id', 'created_at']);
            });
        }

        // ── documentos ────────────────────────────────────────────────────
        if (! Schema::hasTable('documentos')) {
            Schema::create('documentos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('registro_id')->constrained('registro_verificacion')->cascadeOnDelete();
                $table->enum('tipo_documento', ['cedula_anverso', 'cedula_reverso', 'licencia', 'soat', 'crpva']);
                $table->string('ruta_imagen');
                $table->boolean('calidad_legible')->nullable();
                $table->timestamps();
            });
        }

        // ── dato_documento ────────────────────────────────────────────────
        if (! Schema::hasTable('dato_documento')) {
            Schema::create('dato_documento', function (Blueprint $table) {
                $table->id();
                $table->foreignId('documento_id')->constrained('documentos')->cascadeOnDelete();
                $table->string('nombre_campo');
                $table->text('valor_extraido')->nullable();
                $table->timestamps();

                $table->index(['documento_id', 'nombre_campo']);
            });
        }

        // ── resultado_validacion ──────────────────────────────────────────
        if (! Schema::hasTable('resultado_validacion')) {
            Schema::create('resultado_validacion', function (Blueprint $table) {
                $table->id();
                $table->foreignId('registro_id')->constrained('registro_verificacion')->cascadeOnDelete();
                $table->foreignId('parametro_id')->nullable()->constrained('parametros_control')->nullOnDelete();
                $table->enum('resultado', ['aprobado', 'rechazado', 'observado']);
                $table->text('detalle')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('resultado_validacion');
        Schema::dropIfExists('dato_documento');
        Schema::dropIfExists('documentos');
        Schema::dropIfExists('registro_verificacion');
    }
};
