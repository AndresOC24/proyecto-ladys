<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $fillable = [
        'registro_id', 'tipo_documento', 'ruta_imagen', 'calidad_legible',
    ];

    protected $casts = ['calidad_legible' => 'boolean'];

    public function registro(): BelongsTo
    {
        return $this->belongsTo(RegistroVerificacion::class, 'registro_id');
    }

    public function datos(): HasMany
    {
        return $this->hasMany(DatoDocumento::class, 'documento_id');
    }
}
