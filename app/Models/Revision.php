<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revision extends Model
{
    protected $table = 'revisiones';

    protected $fillable = ['user_id', 'administrador_id', 'decision', 'observacion'];

    public function usuaria(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function administrador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administrador_id');
    }
}
