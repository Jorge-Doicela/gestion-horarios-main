<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoAcademico extends Model
{
    use HasFactory;

    protected $table = 'periodos_academicos'; // <- forzamos la tabla correcta

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'periodo_academico_id');
    }
}
