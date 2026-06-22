<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    protected $fillable = [
        'user_id', 'placa', 'marca_modelo', 'relacion_declarada',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
