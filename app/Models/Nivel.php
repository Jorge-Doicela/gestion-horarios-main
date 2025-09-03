<?php

// app/Models/Nivel.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    // Indicar el nombre correcto de la tabla
    protected $table = 'niveles';

    protected $fillable = ['nombre'];

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
}
