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
    protected $options = [];

    public function __construct(PeriodoAcademico $periodo, array $options = [])
    {
        $this->periodo = $periodo;
        $this->options = $this->normalizeOptions($options);
    }

    public function generar()
    {
        $materias = Materia::with('docentes', 'carrera', 'nivel')->get();
        if ($this->options['priorizar_materias']) {
            $materias = $materias->sortByDesc(function ($m) {
                $prioridad = (int) $this->obtenerRestriccion($m, 'prioridad', 0);
                $horasSemana = (int) $this->obtenerRestriccion($m, 'horas_por_semana', 3);
                return ($prioridad * 100) + $horasSemana;
            })->values();
        }
        $dias = Dia::whereIn('id', $this->options['dias'])->get();
        $horasQ = Hora::query();
        if ($this->options['hora_desde']) $horasQ->where('id', '>=', $this->options['hora_desde']);
        if ($this->options['hora_hasta']) $horasQ->where('id', '<=', $this->options['hora_hasta']);
        $horas = $horasQ->get();
        $conflictos = [];

        DB::beginTransaction();

        try {
            // Si se requiere simulación desde options, delegar
            if (isset($this->options['simular']) && $this->options['simular']) {
                return $this->simular();
            }
            foreach ($materias as $materia) {
                Log::info("Procesando materia: {$materia->nombre}");

                $horas_por_semana = (int) $this->obtenerRestriccion($materia, 'horas_por_semana', 3);

                $docente = $materia->docentes->firstWhere('id', fn($id) => in_array($id, $this->options['docentes'])) ?? $materia->docentes->first();
                if (!$docente) {
                    $mensaje = "Materia {$materia->nombre} no tiene docente asignado";
                    Log::warning($mensaje);
                    $conflictos[] = $mensaje;
                    continue;
                }

                // Obtener un paralelo válido para la materia
                $paralelo = Paralelo::where('carrera_id', $materia->carrera_id)
                    ->where('nivel_id', $materia->nivel_id)
                    ->when(!empty($this->options['paralelos']), function ($q) {
                        $q->whereIn('id', $this->options['paralelos']);
                    })
                    ->first();

                if (!$paralelo) {
                    $mensaje = "No hay paralelo disponible para {$materia->nombre}";
                    Log::warning($mensaje);
                    $conflictos[] = $mensaje;
                    continue;
                }

                $horas_asignadas = 0;

                $cargaDocenteSemana = 0;
                foreach ($dias as $dia) {
                    if ($horas_asignadas >= $horas_por_semana) break;

                    $no_dias_docente = explode(',', $this->obtenerRestriccion($docente, 'no_dias', ''));
                    if (in_array($dia->nombre, $no_dias_docente)) {
                        Log::info("Docente {$docente->nombre} no disponible el día {$dia->nombre}");
                        continue;
                    }

                    $cargaDocenteDia = 0;
                    foreach ($horas as $hora) {
                        if ($horas_asignadas >= $horas_por_semana) break;

                        if ($this->options['balancear_carga']) {
                            $limiteDia = (int) $this->obtenerRestriccion($docente, 'max_horas_dia', 4);
                            $limiteSemana = (int) $this->obtenerRestriccion($docente, 'max_horas_semana', 20);
                            if ($cargaDocenteDia >= $limiteDia || $cargaDocenteSemana >= $limiteSemana) {
                                continue;
                            }
                        }

                        $modalidad = $this->pickModalidad();
                        $espacio = null;
                        if ($modalidad !== 'virtual') {
                            $espacio = $this->buscarAulaDisponible($materia, $dia, $hora);
                            if (!$espacio) {
                                Log::info("No hay aula disponible para {$materia->nombre} el día {$dia->nombre}, hora {$hora->hora_inicio}");
                                continue;
                            }
                        }

                        $existe_conflicto = false;
                        if ($this->options['validar_conflictos']) {
                            $existe_conflicto = Horario::where('dia_id', $dia->id)
                                ->where('hora_id', $hora->id)
                                ->where('periodo_academico_id', $this->periodo->id)
                                ->where(function ($q) use ($docente, $paralelo, $espacio) {
                                    $q->where('docente_id', $docente->id)
                                        ->orWhere('paralelo_id', $paralelo->id);
                                    if ($espacio) {
                                        $q->orWhere('espacio_id', $espacio->id);
                                    }
                                })
                                ->exists();
                        }

                        if ($existe_conflicto) {
                            Log::info("Conflicto existente para {$materia->nombre} con docente {$docente->nombre} el día {$dia->nombre}, hora {$hora->hora}");
                            continue;
                        }

                        // Crear horario
                        Horario::create([
                            'materia_id' => $materia->id,
                            'docente_id' => $docente->id,
                            'espacio_id' => $espacio?->id,
                            'dia_id' => $dia->id,
                            'hora_id' => $hora->id,
                            'paralelo_id' => $paralelo->id,
                            'periodo_academico_id' => $this->periodo->id,
                            'semestre_id' => $this->options['semestre_id'] ?? null,
                            'fecha_inicio' => $this->periodo->fecha_inicio,
                            'fecha_fin' => $this->periodo->fecha_fin,
                            'modalidad' => $modalidad,
                            'estado' => 'activo',
                        ]);

                        Log::info("Horario asignado: {$materia->nombre} con {$docente->nombre} en {$espacio->nombre} el día {$dia->nombre}, hora {$hora->hora}");

                        $horas_asignadas++;
                        $cargaDocenteDia++;
                        $cargaDocenteSemana++;
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
                    'motivo' => $mensaje,
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

    public function simular()
    {
        $materias = Materia::with('docentes', 'carrera', 'nivel')->get();
        if ($this->options['priorizar_materias']) {
            $materias = $materias->sortByDesc(function ($m) {
                $prioridad = (int) $this->obtenerRestriccion($m, 'prioridad', 0);
                $horasSemana = (int) $this->obtenerRestriccion($m, 'horas_por_semana', 3);
                return ($prioridad * 100) + $horasSemana;
            })->values();
        }
        $dias = Dia::whereIn('id', $this->options['dias'])->get();
        $horasQ = Hora::query();
        if ($this->options['hora_desde']) $horasQ->where('id', '>=', $this->options['hora_desde']);
        if ($this->options['hora_hasta']) $horasQ->where('id', '<=', $this->options['hora_hasta']);
        $horas = $horasQ->get();

        $conflictos = [];
        $propuestas = [];

        foreach ($materias as $materia) {
            $horas_por_semana = (int) $this->obtenerRestriccion($materia, 'horas_por_semana', 3);
            $docente = $materia->docentes->firstWhere('id', fn($id) => in_array($id, $this->options['docentes'])) ?? $materia->docentes->first();
            if (!$docente) {
                $conflictos[] = "Materia {$materia->nombre} no tiene docente asignado";
                continue;
            }

            $paralelo = Paralelo::where('carrera_id', $materia->carrera_id)
                ->where('nivel_id', $materia->nivel_id)
                ->when(!empty($this->options['paralelos']), function ($q) {
                    $q->whereIn('id', $this->options['paralelos']);
                })
                ->first();
            if (!$paralelo) {
                $conflictos[] = "No hay paralelo disponible para {$materia->nombre}";
                continue;
            }

            $horas_asignadas = 0;
            $cargaDocenteSemana = 0;
            foreach ($dias as $dia) {
                if ($horas_asignadas >= $horas_por_semana) break;
                $no_dias_docente = explode(',', $this->obtenerRestriccion($docente, 'no_dias', ''));
                if (in_array($dia->nombre, $no_dias_docente)) continue;

                $cargaDocenteDia = 0;
                foreach ($horas as $hora) {
                    if ($horas_asignadas >= $horas_por_semana) break;

                    if ($this->options['balancear_carga']) {
                        $limiteDia = (int) $this->obtenerRestriccion($docente, 'max_horas_dia', 4);
                        $limiteSemana = (int) $this->obtenerRestriccion($docente, 'max_horas_semana', 20);
                        if ($cargaDocenteDia >= $limiteDia || $cargaDocenteSemana >= $limiteSemana) continue;
                    }

                    $modalidad = $this->pickModalidad();
                    $espacio = null;
                    if ($modalidad !== 'virtual') {
                        $espacio = $this->buscarAulaDisponible($materia, $dia, $hora);
                        if (!$espacio) continue;
                    }

                    $existe_conflicto = false;
                    if ($this->options['validar_conflictos']) {
                        $existe_conflicto = Horario::where('dia_id', $dia->id)
                            ->where('hora_id', $hora->id)
                            ->where('periodo_academico_id', $this->periodo->id)
                            ->where(function ($q) use ($docente, $paralelo, $espacio) {
                                $q->where('docente_id', $docente->id)
                                    ->orWhere('paralelo_id', $paralelo->id);
                                if ($espacio) {
                                    $q->orWhere('espacio_id', $espacio->id);
                                }
                            })
                            ->exists();
                    }
                    if ($existe_conflicto) continue;

                    $propuestas[] = [
                        'materia' => $materia->nombre,
                        'materia_id' => $materia->id,
                        'docente' => $docente->nombre ?? ($docente->nombres ?? ''),
                        'docente_id' => $docente->id,
                        'paralelo' => $paralelo->nombre,
                        'paralelo_id' => $paralelo->id,
                        'dia' => $dia->nombre,
                        'dia_id' => $dia->id,
                        'hora' => $hora->hora ?? ($hora->hora_inicio . ' - ' . $hora->hora_fin),
                        'hora_id' => $hora->id,
                        'espacio' => $espacio->nombre ?? 'Virtual',
                        'espacio_id' => $espacio?->id,
                        'modalidad' => $modalidad,
                    ];

                    $horas_asignadas++;
                    $cargaDocenteDia++;
                    $cargaDocenteSemana++;
                }
            }
        }

        return [
            'status' => 'ok',
            'propuestas' => $propuestas,
            'conflictos' => $conflictos,
            'horas_propuestas' => count($propuestas),
        ];
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

    protected function normalizeOptions(array $options): array
    {
        return [
            'modalidades' => isset($options['modalidades']) ? (array) $options['modalidades'] : ['presencial', 'virtual', 'hibrida'],
            'paralelos' => isset($options['paralelos']) ? array_map('intval', (array) $options['paralelos']) : [],
            'docentes' => isset($options['docentes']) ? array_map('intval', (array) $options['docentes']) : [],
            'dias' => isset($options['dias']) ? array_map('intval', (array) $options['dias']) : Dia::pluck('id')->all(),
            'hora_desde' => $options['hora_desde'] ?? null,
            'hora_hasta' => $options['hora_hasta'] ?? null,
            'semestre_id' => isset($options['semestre_id']) ? (int) $options['semestre_id'] : null,
            'validar_conflictos' => array_key_exists('validar_conflictos', $options) ? (bool) $options['validar_conflictos'] : true,
            'respetar_restricciones' => array_key_exists('respetar_restricciones', $options) ? (bool) $options['respetar_restricciones'] : true,
            'balancear_carga' => array_key_exists('balancear_carga', $options) ? (bool) $options['balancear_carga'] : true,
            'priorizar_materias' => array_key_exists('priorizar_materias', $options) ? (bool) $options['priorizar_materias'] : true,
        ];
    }

    protected function pickModalidad(): string
    {
        $modalidades = $this->options['modalidades'];
        foreach (['presencial', 'hibrida', 'virtual'] as $pref) {
            if (in_array($pref, $modalidades)) {
                return $pref;
            }
        }
        return 'presencial';
    }
}
