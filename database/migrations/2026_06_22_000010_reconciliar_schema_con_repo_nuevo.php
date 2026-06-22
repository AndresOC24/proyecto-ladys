<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Revertir renombre de Phase 1: nombres → name
        if (Schema::hasColumn('users', 'nombres')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('nombres', 'name');
            });
        }

        // 2. Eliminar columnas de Phase 1
        $dropCols = collect(['apellidos', 'activo'])
            ->filter(fn($c) => Schema::hasColumn('users', $c))
            ->values()->all();
        if ($dropCols) {
            Schema::table('users', function (Blueprint $table) use ($dropCols) {
                $table->dropColumn($dropCols);
            });
        }

        // 3. Renombrar rol_id → role_id (eliminando FK antes si existe)
        if (Schema::hasColumn('users', 'rol_id')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign(['rol_id']);
                });
            } catch (\Throwable) {
                // La FK puede no existir
            }

            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('rol_id', 'role_id');
            });
        }

        // 4. Agregar FK en role_id si no existe
        try {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
            });
        } catch (\Throwable) {
            // FK ya existe
        }

        // 5. Agregar columnas que estaban en migraciones fake-run
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'carnet_anverso_path')) {
                $table->string('carnet_anverso_path')->nullable()->after('numero_carnet');
            }
            if (! Schema::hasColumn('users', 'carnet_reverso_path')) {
                $table->string('carnet_reverso_path')->nullable()->after('carnet_anverso_path');
            }
            if (! Schema::hasColumn('users', 'selfie_path')) {
                $table->string('selfie_path')->nullable()->after('carnet_reverso_path');
            }
            if (! Schema::hasColumn('users', 'licencia_path')) {
                $table->string('licencia_path')->nullable()->after('selfie_path');
            }
            if (! Schema::hasColumn('users', 'resultado_analisis')) {
                $table->json('resultado_analisis')->nullable()->after('estado_verificacion');
            }
            if (! Schema::hasColumn('users', 'analizado_en')) {
                $table->timestamp('analizado_en')->nullable()->after('resultado_analisis');
            }
            if (! Schema::hasColumn('users', 'activa')) {
                $table->boolean('activa')->default(true)->after('analizado_en');
            }
        });

        // 6. Ampliar el ENUM de estado_verificacion para incluir valores del nuevo repo
        DB::statement(
            "ALTER TABLE users MODIFY estado_verificacion ENUM('pendiente','en_proceso','aprobada','rechazada','en_revision','analizando','verificada') DEFAULT 'pendiente'"
        );

        // 7. Crear tabla parametros_control si no existe
        if (! Schema::hasTable('parametros_control')) {
            Schema::create('parametros_control', function (Blueprint $table) {
                $table->id();
                $table->enum('tipo_documento', ['cedula', 'licencia']);
                $table->string('nombre_parametro');
                $table->enum('categoria', ['campo_requerido', 'vigencia', 'formato', 'coherencia']);
                $table->boolean('es_bloqueante')->default(true);
                $table->timestamps();
            });
        }

        // 8. Actualizar nombre del rol: pasajera → pasajero
        DB::table('roles')->where('nombre', 'pasajera')->update(['nombre' => 'pasajero']);
    }

    public function down(): void
    {
        DB::table('roles')->where('nombre', 'pasajero')->update(['nombre' => 'pasajera']);

        Schema::dropIfExists('parametros_control');

        $dropCols = collect([
            'carnet_anverso_path', 'carnet_reverso_path', 'selfie_path',
            'licencia_path', 'resultado_analisis', 'analizado_en', 'activa',
        ])->filter(fn($c) => Schema::hasColumn('users', $c))->values()->all();

        if ($dropCols) {
            Schema::table('users', function (Blueprint $table) use ($dropCols) {
                $table->dropColumn($dropCols);
            });
        }

        try {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
            });
        } catch (\Throwable) {}

        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_id', 'rol_id');
            });
        }

        DB::statement(
            "ALTER TABLE users MODIFY estado_verificacion ENUM('pendiente','en_proceso','aprobada','rechazada','en_revision') DEFAULT 'pendiente'"
        );

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'apellidos')) {
                $table->string('apellidos')->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'activo')) {
                $table->boolean('activo')->default(true)->after('estado_verificacion');
            }
        });

        if (Schema::hasColumn('users', 'name')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('name', 'nombres');
            });
        }
    }
};
