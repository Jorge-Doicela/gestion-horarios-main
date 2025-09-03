<?php

// app/Models/Carrera.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
    ];

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
}
