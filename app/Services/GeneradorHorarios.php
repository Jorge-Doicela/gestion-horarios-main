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
use App\Models\Paralelo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GeneradorHorarios
{
    protected $periodo;

    public function __construct(PeriodoAcademico $periodo)
    {
        $this->periodo = $periodo;
    }

    public function generar()
    {
        $materias = Materia::with('docentes', 'carrera', 'nivel')->get();
        $dias = Dia::all();
        $horas = Hora::all();
        $conflictos = [];

        DB::beginTransaction();

        try {
            foreach ($materias as $materia) {
                Log::info("Procesando materia: {$materia->nombre}");

                $horas_por_semana = (int) $this->obtenerRestriccion($materia, 'horas_por_semana', 3);

                $docente = $materia->docentes->first();
                if (!$docente) {
                    $mensaje = "Materia {$materia->nombre} no tiene docente asignado";
                    Log::warning($mensaje);
                    $conflictos[] = $mensaje;
                    continue;
                }

                // Obtener un paralelo válido para la materia
                $paralelo = Paralelo::where('carrera_id', $materia->carrera_id)
                    ->where('nivel_id', $materia->nivel_id)
                    ->first();

                if (!$paralelo) {
                    $mensaje = "No hay paralelo disponible para {$materia->nombre}";
                    Log::warning($mensaje);
                    $conflictos[] = $mensaje;
                    continue;
                }

                $horas_asignadas = 0;

                foreach ($dias as $dia) {
                    if ($horas_asignadas >= $horas_por_semana) break;

                    $no_dias_docente = explode(',', $this->obtenerRestriccion($docente, 'no_dias', ''));
                    if (in_array($dia->nombre, $no_dias_docente)) {
                        Log::info("Docente {$docente->nombre} no disponible el día {$dia->nombre}");
                        continue;
                    }

                    foreach ($horas as $hora) {
                        if ($horas_asignadas >= $horas_por_semana) break;

                        $espacio = $this->buscarAulaDisponible($materia, $dia, $hora);
                        if (!$espacio) {
                            Log::info("No hay aula disponible para {$materia->nombre} el día {$dia->nombre}, hora {$hora->hora}");
                            continue;
                        }

                        $existe_conflicto = Horario::where('dia_id', $dia->id)
                            ->where('hora_id', $hora->id)
                            ->where('docente_id', $docente->id)
                            ->where('paralelo_id', $paralelo->id)
                            ->where('periodo_academico_id', $this->periodo->id)
                            ->exists();

                        if ($existe_conflicto) {
                            Log::info("Conflicto existente para {$materia->nombre} con docente {$docente->nombre} el día {$dia->nombre}, hora {$hora->hora}");
                            continue;
                        }

                        // Crear horario
                        Horario::create([
                            'materia_id' => $materia->id,
                            'docente_id' => $docente->id,
                            'espacio_id' => $espacio->id,
                            'dia_id' => $dia->id,
                            'hora_id' => $hora->id,
                            'paralelo_id' => $paralelo->id,
                            'periodo_academico_id' => $this->periodo->id,
                            'fecha_inicio' => $this->periodo->fecha_inicio,
                            'fecha_fin' => $this->periodo->fecha_fin,
                            'modalidad' => 'presencial',
                            'estado' => 'activo',
                        ]);

                        Log::info("Horario asignado: {$materia->nombre} con {$docente->nombre} en {$espacio->nombre} el día {$dia->nombre}, hora {$hora->hora}");

                        $horas_asignadas++;
                    }
                }

                if ($horas_asignadas < $horas_por_semana) {
                    $mensaje = "Materia {$materia->nombre} no pudo asignar todas las horas ({$horas_asignadas}/{$horas_por_semana})";
                    Log::warning($mensaje);
                    $conflictos[] = $mensaje;
                }
            }

            foreach ($conflictos as $mensaje) {
                Conflicto::create([
                    'horario_id' => null,
                    'tipo' => 'generacion',
                    'descripcion' => $mensaje,
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
            Log::error("Error al generar horarios: " . $e->getMessage());
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
            $capacidad = (int) $this->obtenerRestriccion($aula, 'capacidad_max', 999);
            $grupo = $materia->grupo ?? 30;

            if ($capacidad < $grupo) continue;

            $ocupado = Horario::where('espacio_id', $aula->id)
                ->where('dia_id', $dia->id)
                ->where('hora_id', $hora->id)
                ->where('periodo_academico_id', $this->periodo->id)
                ->exists();

            if ($ocupado) continue;

            return $aula;
        }

        return null;
    }
}
