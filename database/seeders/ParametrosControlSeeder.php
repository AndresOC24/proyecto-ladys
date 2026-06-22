<?php

namespace Database\Seeders;

use App\Models\ParametroControl;
use Illuminate\Database\Seeder;

class ParametrosControlSeeder extends Seeder
{
    /**
     * Refleja en BD las reglas que hoy aplica el validador Python
     * (servicios/validador_control.py y validador_licencia.py). Esta tabla deja
     * los parámetros configurables desde Laravel; la integración con el servicio
     * de IA queda pendiente (se sigue validando en Python por ahora).
     */
    public function run(): void
    {
        $parametros = [
            // --- Cédula de identidad ---
            ['cedula', 'numero_cedula', 'campo_requerido', true],
            ['cedula', 'fecha_nacimiento', 'campo_requerido', true],
            ['cedula', 'fecha_expiracion', 'vigencia', true],

            // --- Licencia de conducir ---
            ['licencia', 'categoria_profesional', 'coherencia', true],
            ['licencia', 'fecha_expiracion', 'vigencia', true],
        ];

        foreach ($parametros as [$tipo, $nombre, $categoria, $bloqueante]) {
            ParametroControl::firstOrCreate(
                ['tipo_documento' => $tipo, 'nombre_parametro' => $nombre],
                ['categoria' => $categoria, 'es_bloqueante' => $bloqueante],
            );
        }
    }
}
