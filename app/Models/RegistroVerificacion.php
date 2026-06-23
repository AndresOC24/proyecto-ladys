<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RegistroVerificacion extends Model
{
    protected $table = 'registro_verificacion';

    protected $fillable = [
        'user_id', 'tipo_registro', 'ruta_selfie', 'estado_resultado',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'registro_id');
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(ResultadoValidacion::class, 'registro_id');
    }
}
