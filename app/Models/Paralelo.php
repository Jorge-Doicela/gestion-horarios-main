<?php
// app/Models/Paralelo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'carrera_id', 'nivel_id'];

    // Relación con Carrera
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    // Relación con Nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
