<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'numero_carnet')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->string('numero_carnet', 20)->nullable()->after('apellidos');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('numero_carnet');
        });
    }
};
