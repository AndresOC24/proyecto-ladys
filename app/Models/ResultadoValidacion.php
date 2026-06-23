<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoValidacion extends Model
{
    protected $table = 'resultado_validacion';

    protected $fillable = ['registro_id', 'parametro_id', 'resultado', 'detalle'];

    public function registro(): BelongsTo
    {
        return $this->belongsTo(RegistroVerificacion::class, 'registro_id');
    }

    public function parametro(): BelongsTo
    {
        return $this->belongsTo(ParametroControl::class, 'parametro_id');
    }
}
