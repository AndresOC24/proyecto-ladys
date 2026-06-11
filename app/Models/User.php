<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        'telefono', 'fecha_nacimiento', 'numero_carnet',
        'carnet_anverso_path', 'carnet_reverso_path',
        'estado_verificacion', 'resultado_analisis', 'analizado_en',
    ];
    

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
            'resultado_analisis' => 'array',
            'analizado_en' => 'datetime',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $nombre): bool
    {
        return $this->role?->nombre === $nombre;
    }

    public function esAdministrador(): bool
    {
        return $this->hasRole(Role::ADMINISTRADOR);
    }

    public function esPasajero(): bool
    {
        return $this->hasRole(Role::PASAJERO);
    }

    public function esConductora(): bool
    {
        return $this->hasRole(Role::CONDUCTORA);
    }
}
