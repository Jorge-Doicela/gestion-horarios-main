<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conflicto extends Model
{
    use HasFactory;

    protected $fillable = [
        'horario_id',
        'tipo',
        'motivo'
    ];

    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
