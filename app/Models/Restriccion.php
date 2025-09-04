<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restriccion extends Model
{
    use HasFactory;

    // Indicar la tabla correcta
    protected $table = 'restricciones';

    protected $fillable = [
        'tipo',          // docente, aula, materia, estudiante
        'referencia_id', // id de la entidad a la que aplica
        'clave',         // clave de la restricción, ej: 'hora', 'dia', 'max_alumnos'
        'valor',         // valor correspondiente a la clave
    ];

    /**
     * Relación con la entidad a la que aplica la restricción.
     */
    public function referencia()
    {
        switch ($this->tipo) {
            case 'docente':
                return $this->belongsTo(\App\Models\Docente::class, 'referencia_id');
            case 'aula':
                return $this->belongsTo(\App\Models\Espacio::class, 'referencia_id');
            case 'materia':
                return $this->belongsTo(\App\Models\Materia::class, 'referencia_id');
            case 'estudiante':
                return $this->belongsTo(\App\Models\User::class, 'referencia_id'); // si estudiantes son usuarios
            default:
                return null;
        }
    }
}
