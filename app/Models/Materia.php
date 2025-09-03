<?php

// app/Models/Materia.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'carrera_id',
        'nivel_id',
        'creditos',
        'tipo'
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
