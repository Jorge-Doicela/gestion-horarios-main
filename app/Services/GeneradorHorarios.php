<?php

namespace App\Services;

use App\Models\Materia;
use App\Models\Docente;
use App\Models\Espacio;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\PeriodoAcademico;
use App\Models\Restriccion;
use App\Models\Horario;
use App\Models\Conflicto;
use Illuminate\Support\Facades\DB;

class GeneradorHorarios
{
    protected $periodo;

    public function __construct(PeriodoAcademico $periodo)
    {
        $this->periodo = $periodo;
    }

    public function generar()
    {
        $materias = Materia::all(); // O filtrar por semestre/carrera
        $dias = Dia::all();
        $horas = Hora::all();
        $conflictos = [];

        DB::beginTransaction();

        try {
            foreach ($materias as $materia) {
                $horas_por_semana = (int) $this->obtenerRestriccion($materia, 'horas_por_semana', 3); // default 3
                $docente = $materia->docentes()->first();

                if (!$docente) {
                    $conflictos[] = "Materia {$materia->nombre} no tiene docente asignado";
                    continue;
                }

                $horas_asignadas = 0;

                foreach ($dias as $dia) {
                    if ($horas_asignadas >= $horas_por_semana) break;

                    // Validar restricción de no_dias para docente
                    $no_dias_docente = explode(',', $this->obtenerRestriccion($docente, 'no_dias', ''));
                    if (in_array($dia->nombre, $no_dias_docente)) continue;

                    foreach ($horas as $hora) {
                        if ($horas_asignadas >= $horas_por_semana) break;

                        // Buscar aula disponible
                        $espacio = $this->buscarAulaDisponible($materia, $dia, $hora);

                        if (!$espacio) continue;

                        // Validar que no exista conflicto
                        $existe_conflicto = Horario::where([
                            'dia_id' => $dia->id,
                            'hora_id' => $hora->id,
                            'docente_id' => $docente->id,
                            'periodo_academico_id' => $this->periodo->id
                        ])->exists();

                        if ($existe_conflicto) continue;

                        // Insertar horario
                        Horario::create([
                            'materia_id' => $materia->id,
                            'docente_id' => $docente->id,
                            'espacio_id' => $espacio->id,
                            'dia_id' => $dia->id,
                            'hora_id' => $hora->id,
                            'paralelo_id' => $materia->paralelo_id ?? 1, // Ajustar según modelo
                            'periodo_academico_id' => $this->periodo->id,
                            'fecha_inicio' => $this->periodo->fecha_inicio,
                            'fecha_fin' => $this->periodo->fecha_fin,
                            'modalidad' => 'presencial',
                            'estado' => 'activo',
                        ]);

                        $horas_asignadas++;
                    }
                }

                if ($horas_asignadas < $horas_por_semana) {
                    $conflictos[] = "Materia {$materia->nombre} no pudo asignar todas las horas ({$horas_asignadas}/{$horas_por_semana})";
                }
            }

            // Guardar conflictos
            foreach ($conflictos as $mensaje) {
                Conflicto::create([
                    'materia_id' => null,
                    'motivo' => $mensaje
                ]);
            }

            DB::commit();

            return [
                'status' => 'ok',
                'horarios_generados' => Horario::where('periodo_academico_id', $this->periodo->id)->count(),
                'conflictos' => count($conflictos)
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'mensaje' => $e->getMessage()
            ];
        }
    }

    protected function obtenerRestriccion($objeto, $clave, $default = null)
    {
        $tipo = strtolower(class_basename($objeto));
        switch ($tipo) {
            case 'docente':
                $tipo = 'docente';
                break;
            case 'materia':
                $tipo = 'materia';
                break;
            case 'espacio':
                $tipo = 'aula';
                break;
            case 'user':
                $tipo = 'estudiante';
                break;
        }

        $r = Restriccion::where('tipo', $tipo)
            ->where('referencia_id', $objeto->id)
            ->where('clave', $clave)
            ->first();

        return $r ? $r->valor : $default;
    }

    protected function buscarAulaDisponible($materia, $dia, $hora)
    {
        $aulas = Espacio::where('tipo', 'aula')->get();

        foreach ($aulas as $aula) {
            // Validar capacidad
            $capacidad = (int) $this->obtenerRestriccion($aula, 'capacidad_max', 999);
            $grupo = $materia->grupo ?? 30; // Ajustar según modelo

            if ($capacidad < $grupo) continue;

            // Validar conflicto de espacio
            $ocupado = Horario::where([
                'espacio_id' => $aula->id,
                'dia_id' => $dia->id,
                'hora_id' => $hora->id,
                'periodo_academico_id' => $this->periodo->id
            ])->exists();

            if ($ocupado) continue;

            return $aula;
        }

        return null;
    }
}
