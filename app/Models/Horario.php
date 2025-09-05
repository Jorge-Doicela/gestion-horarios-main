<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'paralelo_id',
        'materia_id',
        'docente_id',
        'espacio_id',
        'dia_id',
        'hora_id',
        'periodo_academico_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'modalidad',
        'observaciones',
    ];

    // Relaciones
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }
    public function dia()
    {
        return $this->belongsTo(Dia::class);
    }
    public function hora()
    {
        return $this->belongsTo(Hora::class);
    }
    public function periodo()
    {
        return $this->belongsTo(PeriodoAcademico::class, 'periodo_academico_id');
    }

    

    public function conflictos()
    {
        return $this->hasMany(Conflicto::class);
    }

    public function restricciones()
    {
        return $this->hasMany(Restriccion::class, 'referencia_id', 'docente_id');
        // luego ajustaremos para paralelos y espacios según tipo
    }
}
