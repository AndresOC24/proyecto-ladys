<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            // En el diagrama el vehículo cuelga de «registro_verificacion». En este
            // sistema el registro es la propia usuaria (modelo desnormalizado), así
            // que lo vinculamos directamente a users.
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('placa', 20);
            $table->string('marca_modelo');
            $table->enum('relacion_declarada', ['propio', 'familiar', 'alquilado', 'otro'])
                  ->default('propio');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
