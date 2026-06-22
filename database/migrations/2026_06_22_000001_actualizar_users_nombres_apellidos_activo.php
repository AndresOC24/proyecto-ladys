<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'nombres');
            $table->string('apellidos')->nullable()->after('nombres');
            $table->boolean('activo')->default(true)->after('estado_verificacion');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['apellidos', 'activo']);
            $table->renameColumn('nombres', 'name');
        });
    }
};
