<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametroControl extends Model
{
    protected $table = 'parametros_control';

    protected $fillable = [
        'tipo_documento', 'nombre_parametro', 'categoria', 'es_bloqueante',
    ];

    protected function casts(): array
    {
        return [
            'es_bloqueante' => 'boolean',
        ];
    }
}
