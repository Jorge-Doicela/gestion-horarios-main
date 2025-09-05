<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'paralelo_id', // 🔹 Necesario si cada usuario pertenece a un paralelo
    ];

    /**
     * Los atributos que deben estar ocultos en arrays/JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser casteados.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Nota: Relaciones para futuras implementaciones
    // public function documentos()
    // {
    //     return $this->hasMany(Documento::class);
    // }

    // public function logs()
    // {
    //     return $this->hasMany(Log::class);
    // }

    /**
     * Relación: Un usuario pertenece a un paralelo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
}
