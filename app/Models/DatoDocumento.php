<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatoDocumento extends Model
{
    protected $table = 'dato_documento';

    protected $fillable = ['documento_id', 'nombre_campo', 'valor_extraido'];

    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
