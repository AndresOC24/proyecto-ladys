<?php

namespace App\Services;

use App\Models\Bitacora;

class BitacoraService
{
    public static function registrar(
        string $accion,
        ?string $modelo = null,
        ?int $modeloId = null,
        array $detalles = [],
        ?int $userId = null
    ): void {
        Bitacora::create([
            'user_id'   => $userId ?? auth()->id(),
            'accion'    => $accion,
            'modelo'    => $modelo,
            'modelo_id' => $modeloId,
            'detalles'  => empty($detalles) ? null : $detalles,
        ]);
    }
}
