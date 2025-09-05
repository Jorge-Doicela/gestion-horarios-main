<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Espacio;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\PeriodoAcademico;
use App\Models\Conflicto;
use Illuminate\Http\Request;
use App\Services\GeneradorHorarios;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exports\HorariosExport;
use App\Exports\HorarioEstudianteExport;
use App\Exports\HorariosFiltradosExport;
use App\Exports\SimulacionExport;



class HorarioController extends Controller
{
    public function __construct()
    {
        // Middleware: solo usuarios autenticados
        $this->middleware('auth');
    }

    // Vista del generador automático (solo admin via ruta)
    public function generador(Request $request)
    {
        // Datos para filtros y validaciones previas
        $periodos = PeriodoAcademico::orderBy('nombre')->get();
        $paralelos = Paralelo::orderBy('nombre')->get();
        $docentes = Docente::orderBy('nombre')->get();
        $materias = Materia::orderBy('nombre')->get();
        $horas = Hora::orderBy('hora_inicio')->get();
        $dias = Dia::orderBy('id')->get();

        return view('admin.horarios.generador', compact('periodos', 'paralelos', 'docentes', 'materias', 'horas', 'dias'));
    }

    // Mostrar todos los horarios con paginación, filtros y búsqueda
    public function index(Request $request)
    {
        $query = Horario::with(['paralelo', 'materia', 'docente', 'espacio', 'dia', 'hora', 'periodo']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('periodo_id')) {
            $query->where('periodo_academico_id', $request->periodo_id);
        }

        if ($request->filled('docente_id')) {
            $query->where('docente_id', $request->docente_id);
        }

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('materia', function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%");
                })
                    ->orWhereHas('docente', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('paralelo', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('espacio', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    });
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['materia', 'docente', 'paralelo', 'espacio'])) {
            $query->join($sortBy . 's', 'horarios.' . $sortBy . '_id', '=', $sortBy . 's.id')
                ->orderBy($sortBy . 's.nombre', $sortDirection)
                ->select('horarios.*');
        } else {
            $query->orderBy($sortBy, $sortDirection);
        }

        $horarios = $query->paginate(15)->withQueryString();

        // Datos para filtros
        $estados = ['activo', 'suspendido', 'finalizado'];
        $modalidades = ['presencial', 'virtual', 'hibrida'];
        $periodos = PeriodoAcademico::orderBy('nombre')->get();
        $docentes = Docente::orderBy('nombre')->get();
        $paralelos = Paralelo::orderBy('nombre')->get();

        return view('horarios.index', compact(
            'horarios',
            'estados',
            'modalidades',
            'periodos',
            'docentes',
            'paralelos'
        ));
    }

    // Formulario de creación
    public function create()
    {
        return view('horarios.create', [
            'paralelos' => Paralelo::all(),
            'materias' => Materia::all(),
            'docentes' => Docente::all(),
            'espacios' => Espacio::all(),
            'dias' => Dia::all(),
            'horas' => Hora::all(),
            'periodos' => PeriodoAcademico::all(),
        ]);
    }

    // Guardar nuevo horario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paralelo_id' => 'required|exists:paralelos,id',
            'materia_id' => 'required|exists:materias,id',
            'docente_id' => 'required|exists:docentes,id',
            'espacio_id' => 'nullable|exists:espacios,id',
            'dia_id' => 'required|exists:dias,id',
            'hora_id' => 'required|exists:horas,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,suspendido,finalizado',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'paralelo_id.required' => 'El paralelo es obligatorio.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'materia_id.required' => 'La materia es obligatoria.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'docente_id.required' => 'El docente es obligatorio.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'espacio_id.exists' => 'El espacio seleccionado no existe.',
            'dia_id.required' => 'El día es obligatorio.',
            'dia_id.exists' => 'El día seleccionado no existe.',
            'hora_id.required' => 'La hora es obligatoria.',
            'hora_id.exists' => 'La hora seleccionada no existe.',
            'periodo_academico_id.required' => 'El período académico es obligatorio.',
            'periodo_academico_id.exists' => 'El período académico seleccionado no existe.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: activo, suspendido o finalizado.',
            'modalidad.required' => 'La modalidad es obligatoria.',
            'modalidad.in' => 'La modalidad debe ser: presencial, virtual o híbrida.',
            'observaciones.string' => 'Las observaciones deben ser texto.',
            'observaciones.max' => 'Las observaciones no pueden exceder los 500 caracteres.',
        ]);

        if ($validated['estado'] === 'activo') {
            $conflictos = $this->validarConflictos($validated);
            if ($conflictos) {
                return back()->withInput()->withErrors($conflictos);
            }
        }

        $verificacion = $this->verificarModalidad($request);
        if ($verificacion !== true) {
            return $verificacion;
        }

        Horario::create($validated);

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

    // Formulario de edición
    public function edit(Horario $horario)
    {
        if ($horario->estado !== 'activo') {
            return back()->withErrors(['estado' => 'No se puede modificar un horario ' . $horario->estado . '.']);
        }

        return view('horarios.edit', [
            'horario' => $horario,
            'paralelos' => Paralelo::all(),
            'materias' => Materia::all(),
            'docentes' => Docente::all(),
            'espacios' => Espacio::all(),
            'dias' => Dia::all(),
            'horas' => Hora::all(),
            'periodos' => PeriodoAcademico::all(),
        ]);
    }

    // Actualizar horario
    public function update(Request $request, Horario $horario)
    {
        if ($horario->estado !== 'activo') {
            return back()->withErrors(['estado' => 'No se puede modificar un horario ' . $horario->estado . '.']);
        }

        $validated = $request->validate([
            'paralelo_id' => 'required|exists:paralelos,id',
            'materia_id' => 'required|exists:materias,id',
            'docente_id' => 'required|exists:docentes,id',
            'espacio_id' => 'nullable|exists:espacios,id',
            'dia_id' => 'required|exists:dias,id',
            'hora_id' => 'required|exists:horas,id',
            'periodo_academico_id' => 'required|exists:periodos_academicos,id',
            
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,suspendido,finalizado',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'observaciones' => 'nullable|string|max:500',
        ]);

        if ($validated['estado'] === 'activo') {
            $conflictos = $this->validarConflictos($validated, $horario->id);
            if ($conflictos) {
                return back()->withInput()->withErrors($conflictos);
            }
        }

        $verificacion = $this->verificarModalidad($request);
        if ($verificacion !== true) {
            return $verificacion;
        }

        $horario->update($validated);

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    // Eliminar horario
    public function destroy(Horario $horario)
    {
        if ($horario->estado === 'finalizado') {
            return back()->withErrors(['estado' => 'No se puede eliminar un horario finalizado.']);
        }

        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }

    // Cambiar estado de un horario
    public function cambiarEstado($id, $nuevoEstado)
    {
        $horario = Horario::findOrFail($id);

        if (!in_array($nuevoEstado, ['activo', 'suspendido', 'finalizado'])) {
            return back()->withErrors(['estado' => 'Estado inválido.']);
        }

        $horario->estado = $nuevoEstado;
        $horario->save();

        return redirect()->back()->with('success', 'Estado del horario actualizado a ' . $nuevoEstado);
    }

    // Método privado: validar conflictos de horarios
    private function validarConflictos(array $data, int $idHorarioActual = null)
    {
        $conflictos = [];

        $hora = Hora::find($data['hora_id']);
        $horaInicio = $hora->hora_inicio;
        $horaFin = $hora->hora_fin;

        $solapamiento = function ($query) use ($horaInicio, $horaFin, $idHorarioActual) {
            $query->where(function ($q) use ($horaInicio, $horaFin) {
                $q->where('hora_inicio', '<', $horaFin)
                    ->where('hora_fin', '>', $horaInicio);
            });

            if ($idHorarioActual) {
                $query->where('id', '!=', $idHorarioActual);
            }

            return $query->where('estado', 'activo');
        };

        // Docente
        $queryDocente = $solapamiento(Horario::where('docente_id', $data['docente_id'])
            ->where('dia_id', $data['dia_id'])
            ->where('periodo_academico_id', $data['periodo_academico_id']));
        if ($queryDocente->exists()) {
            $conflictos['docente_id'] = 'El docente tiene otra clase solapada en este horario.';
        }

        // Espacio
        if ($data['espacio_id']) {
            $queryEspacio = $solapamiento(Horario::where('espacio_id', $data['espacio_id'])
                ->where('dia_id', $data['dia_id'])
                ->where('periodo_academico_id', $data['periodo_academico_id']));
            if ($queryEspacio->exists()) {
                $conflictos['espacio_id'] = 'El espacio ya está ocupado en este horario.';
            }
        }

        // Paralelo
        $queryParalelo = $solapamiento(Horario::where('paralelo_id', $data['paralelo_id'])
            ->where('dia_id', $data['dia_id'])
            ->where('periodo_academico_id', $data['periodo_academico_id']));
        if ($queryParalelo->exists()) {
            $conflictos['paralelo_id'] = 'Este paralelo ya tiene otra materia en este horario.';
        }

        // Materia
        $queryMateria = $solapamiento(Horario::where('materia_id', $data['materia_id'])
            ->where('dia_id', $data['dia_id'])
            ->where('periodo_academico_id', $data['periodo_academico_id']));
        if ($queryMateria->exists()) {
            $conflictos['materia_id'] = 'Esta materia ya está programada en otro paralelo en el mismo horario.';
        }

        return $conflictos ?: null;
    }

    // Método privado: verificar modalidad y disponibilidad de espacio
    private function verificarModalidad(Request $request)
    {
        $modalidad = $request->modalidad;

        if (!in_array($modalidad, ['presencial', 'virtual', 'hibrida'])) {
            return back()->withInput()->withErrors(['modalidad' => 'Modalidad inválida.']);
        }

        if (in_array($modalidad, ['presencial', 'hibrida'])) {
            if (!$request->espacio_id) {
                return back()->withInput()->withErrors(['espacio_id' => 'Debe asignarse un espacio para la modalidad ' . $modalidad . '.']);
            }

            $espacio = Espacio::find($request->espacio_id);
            if (!$espacio || !$espacio->disponible) {
                return back()->withInput()->withErrors(['espacio_id' => 'El espacio seleccionado no está disponible.']);
            }
        }

        return true;
    }

    // Mostrar calendario
    public function calendario(Request $request)
    {
        $periodos = PeriodoAcademico::all();

        // Si no hay períodos, retorna vista vacía con mensaje
        if ($periodos->isEmpty()) {
            return view('horarios.calendario', [
                'horarios' => collect(),
                'conflictos' => collect(),
                'periodos' => collect(),
                'periodo_id' => null,
                'error' => 'No hay períodos académicos registrados.'
            ]);
        }

        $periodo_id = $request->query('periodo_id') ?? $periodos->first()->id;

        $horarios = Horario::with(['materia', 'docente', 'espacio', 'dia', 'hora'])
            ->where('periodo_academico_id', $periodo_id)
            ->get();

        $conflictos = Conflicto::whereHas('horario', function ($query) use ($periodo_id) {
            $query->where('periodo_academico_id', $periodo_id);
        })->get();

        return view('horarios.calendario', compact('horarios', 'conflictos', 'periodos', 'periodo_id'));
    }



    // Generación automática de horarios
    public function generarAutomatico(Request $request)
    {
        try {
            \Log::info('Iniciando generación automática de horarios', ['request' => $request->all()]);

            $periodo = PeriodoAcademico::findOrFail($request->periodo_id);
            \Log::info('Período encontrado', ['periodo' => $periodo->toArray()]);

            $options = [
                'modalidades' => $request->input('modalidades', ['presencial', 'virtual', 'hibrida']),
                'paralelos' => $request->input('paralelos', []),
                'docentes' => $request->input('docentes', []),
                'dias' => $request->input('dias', []),
                'hora_desde' => $request->input('hora_desde'),
                'hora_hasta' => $request->input('hora_hasta'),
                
                'validar_conflictos' => (bool) $request->input('validar_conflictos', true),
                'respetar_restricciones' => (bool) $request->input('respetar_restricciones', true),
                'balancear_carga' => (bool) $request->input('balancear_carga', true),
                'priorizar_materias' => (bool) $request->input('priorizar_materias', true),
            ];

            // Soporte de simulación (previsualización)
            $simular = (bool) $request->input('simular', false);
            $generador = new GeneradorHorarios($periodo, array_merge($options, ['simular' => $simular]));
            $resultado = $simular ? $generador->simular() : $generador->generar();

            \Log::info('Resultado de la generación', ['resultado' => $resultado]);

            if ($resultado['status'] === 'error') {
                \Log::error('Error en la generación', ['error' => $resultado['mensaje'] ?? 'Error desconocido']);
                return redirect()->back()->withErrors(['error' => $resultado['mensaje'] ?? 'Error desconocido']);
            }

            if ($simular) {
                return view('admin.horarios.simulacion', [
                    'periodo' => $periodo,
                    'resultado' => $resultado,
                    'options' => $options,
                ]);
            }

            return redirect()->route('horarios.calendario', ['periodo_id' => $periodo->id])
                ->with('success', 'Generación finalizada. '
                    . ($resultado['horarios_generados'] ?? 0) . ' horarios creados. '
                    . ($resultado['conflictos'] ?? 0) . ' conflictos.');
        } catch (\Exception $e) {
            \Log::error('Excepción en generarAutomatico', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }

    public function exportPDF(Request $request)
    {
        $periodo_id = $request->query('periodo_id') ?? PeriodoAcademico::first()->id;

        $horarios = Horario::with(['materia', 'paralelo', 'docente', 'espacio', 'dia', 'hora'])
            ->where('periodo_academico_id', $periodo_id)
            ->get();

        $dias = Dia::orderBy('id')->get();
        $horas = Hora::orderBy('hora_inicio')->get();

        $pdf = Pdf::loadView('horarios.pdf', compact('horarios', 'dias', 'horas'));
        return $pdf->download('horario_periodo_' . $periodo_id . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $periodo_id = $request->query('periodo_id') ?? PeriodoAcademico::first()->id;
        return Excel::download(new HorariosExport($periodo_id), 'horario_periodo_' . $periodo_id . '.xlsx');
    }

    // Exportación PDF de simulación
    public function simulacionPDF(Request $request)
    {
        $periodo = PeriodoAcademico::findOrFail($request->periodo_id);
        $options = [
            'modalidades' => $request->input('modalidades', ['presencial', 'virtual', 'hibrida']),
            'paralelos' => $request->input('paralelos', []),
            'docentes' => $request->input('docentes', []),
            'dias' => $request->input('dias', []),
            'hora_desde' => $request->input('hora_desde'),
            'hora_hasta' => $request->input('hora_hasta'),
            'validar_conflictos' => (bool) $request->input('validar_conflictos', true),
            'respetar_restricciones' => (bool) $request->input('respetar_restricciones', true),
            'balancear_carga' => (bool) $request->input('balancear_carga', true),
            'priorizar_materias' => (bool) $request->input('priorizar_materias', true),
            'simular' => true,
        ];
        $generador = new GeneradorHorarios($periodo, $options);
        $resultado = $generador->simular();

        // Filtros rápidos opcionales
        $fDocente = $request->query('f_docente');
        $fParalelo = $request->query('f_paralelo');
        if ($fDocente || $fParalelo) {
            $resultado['propuestas'] = collect($resultado['propuestas'] ?? [])->filter(function ($p) use ($fDocente, $fParalelo) {
                if ($fDocente && (string)($p['docente_id'] ?? '') !== (string)$fDocente) return false;
                if ($fParalelo && (string)($p['paralelo_id'] ?? '') !== (string)$fParalelo) return false;
                return true;
            })->values()->all();
            $resultado['horas_propuestas'] = count($resultado['propuestas']);
        }

        $pdf = Pdf::loadView('admin.horarios.simulacion_pdf', [
            'periodo' => $periodo,
            'resultado' => $resultado,
            'options' => $options,
        ]);
        return $pdf->download('simulacion_horarios_' . $periodo->id . '.pdf');
    }

    // Exportación Excel de simulación
    public function simulacionExcel(Request $request)
    {
        $periodo = PeriodoAcademico::findOrFail($request->periodo_id);
        $options = [
            'modalidades' => $request->input('modalidades', ['presencial', 'virtual', 'hibrida']),
            'paralelos' => $request->input('paralelos', []),
            'docentes' => $request->input('docentes', []),
            'dias' => $request->input('dias', []),
            'hora_desde' => $request->input('hora_desde'),
            'hora_hasta' => $request->input('hora_hasta'),
            'validar_conflictos' => (bool) $request->input('validar_conflictos', true),
            'respetar_restricciones' => (bool) $request->input('respetar_restricciones', true),
            'balancear_carga' => (bool) $request->input('balancear_carga', true),
            'priorizar_materias' => (bool) $request->input('priorizar_materias', true),
            'simular' => true,
        ];
        $generador = new GeneradorHorarios($periodo, $options);
        $resultado = $generador->simular();

        // Filtros rápidos opcionales
        $fDocente = $request->query('f_docente');
        $fParalelo = $request->query('f_paralelo');
        if ($fDocente || $fParalelo) {
            $resultado['propuestas'] = collect($resultado['propuestas'] ?? [])->filter(function ($p) use ($fDocente, $fParalelo) {
                if ($fDocente && (string)($p['docente_id'] ?? '') !== (string)$fDocente) return false;
                if ($fParalelo && (string)($p['paralelo_id'] ?? '') !== (string)$fParalelo) return false;
                return true;
            })->values()->all();
            $resultado['horas_propuestas'] = count($resultado['propuestas']);
        }

        return Excel::download(new SimulacionExport($periodo, $resultado), 'simulacion_horarios_' . $periodo->id . '.xlsx');
    }

    // Exportar horarios filtrados a Excel
    public function exportExcelFiltrado(Request $request)
    {
        $query = Horario::with(['paralelo', 'materia', 'docente', 'espacio', 'dia', 'hora', 'periodo']);

        // Aplicar los mismos filtros que en el index
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('periodo_id')) {
            $query->where('periodo_academico_id', $request->periodo_id);
        }

        if ($request->filled('docente_id')) {
            $query->where('docente_id', $request->docente_id);
        }

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('materia', function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%");
                })
                    ->orWhereHas('docente', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('paralelo', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('espacio', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    });
            });
        }

        $horarios = $query->get();

        $filename = 'horarios_filtrados_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new HorariosFiltradosExport($horarios), $filename);
    }

    // Exportar horarios filtrados a PDF
    public function exportPDFFiltrado(Request $request)
    {
        $query = Horario::with(['paralelo', 'materia', 'docente', 'espacio', 'dia', 'hora', 'periodo']);

        // Aplicar los mismos filtros que en el index
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('periodo_id')) {
            $query->where('periodo_academico_id', $request->periodo_id);
        }

        if ($request->filled('docente_id')) {
            $query->where('docente_id', $request->docente_id);
        }

        if ($request->filled('paralelo_id')) {
            $query->where('paralelo_id', $request->paralelo_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('materia', function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%");
                })
                    ->orWhereHas('docente', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('paralelo', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('espacio', function ($subQuery) use ($search) {
                        $subQuery->where('nombre', 'like', "%{$search}%");
                    });
            });
        }

        $horarios = $query->get();

        $pdf = Pdf::loadView('horarios.pdf_filtrado', compact('horarios'));
        $filename = 'horarios_filtrados_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return $pdf->download($filename);
    }

    // Mostrar horario del estudiante
    // Mostrar horario del estudiante
    public function horarioEstudiante(Request $request)
    {
        $user = auth()->user();
        $paralelo = $user->paralelo;

        $dias = \App\Models\Dia::orderBy('id')->get();
        $horas = \App\Models\Hora::orderBy('hora_inicio')->get();

        $horarios = collect();
        $error = null;

        if (!$paralelo) {
            $error = 'No estás asignado a ningún paralelo.';
        } else {
            $horarios = Horario::with(['materia', 'docente', 'espacio', 'dia', 'hora'])
                ->where('paralelo_id', $paralelo->id)
                ->where('estado', 'activo')
                ->get();
        }

        // Reorganizar horarios por hora y día para la vista
        $horarios_matriz = [];
        foreach ($horarios as $h) {
            $horarios_matriz[$h->hora_id][$h->dia_id] = $h;
        }

        return view('horarios.estudiante', compact('horarios', 'horarios_matriz', 'dias', 'horas', 'paralelo', 'error'));
    }

    public function exportPDFEstudiante()
    {
        $user = auth()->user();
        $paralelo = $user->paralelo;

        $dias = \App\Models\Dia::orderBy('id')->get();
        $horas = \App\Models\Hora::orderBy('hora_inicio')->get();

        if (!$paralelo) {
            return redirect()->back()->withErrors(['error' => 'No estás asignado a ningún paralelo.']);
        }

        $horarios = Horario::with(['materia', 'docente', 'espacio', 'dia', 'hora'])
            ->where('paralelo_id', $paralelo->id)
            ->where('estado', 'activo')
            ->get();

        // Convertir a matriz para usar en la vista
        $horarios_matriz = [];
        foreach ($horarios as $h) {
            $horarios_matriz[$h->hora_id][$h->dia_id] = $h;
        }

        $pdf = Pdf::loadView('horarios.estudiante_pdf', compact('horas', 'dias', 'horarios_matriz', 'paralelo'));
        return $pdf->download('horario_estudiante.pdf');
    }
    public function exportExcelEstudiante()
    {
        $user = auth()->user();
        $paralelo = $user->paralelo;

        if (!$paralelo) {
            return redirect()->back()->withErrors(['error' => 'No estás asignado a ningún paralelo.']);
        }

        return Excel::download(new HorarioEstudianteExport($paralelo->id), 'horario_estudiante.xlsx');
    }
}
