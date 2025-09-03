<?php

// app/Models/Hora.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    use HasFactory;

    protected $fillable = ['hora_inicio', 'hora_fin'];

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
