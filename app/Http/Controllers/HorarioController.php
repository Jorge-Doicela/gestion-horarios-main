<?php
// app/Http/Controllers/HorarioController.php
namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Espacio;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function __construct()
    {
        // Middleware: solo usuarios autenticados
        $this->middleware('auth');

        // Middleware: solo roles admin o coordinador
        $this->middleware('role:Administrador|Coordinador Académico');
    }

    public function index()
    {
        $horarios = Horario::with(['paralelo', 'materia', 'docente', 'espacio', 'dia', 'hora', 'periodo'])
            ->get(); // mostramos todos los horarios (no solo activos)

        return view('horarios.index', compact('horarios'));
    }

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
        ]);

        // Validar conflictos solo si horario activo
        if ($validated['estado'] === 'activo') {
            $conflictos = $this->validarConflictos($validated);
            if ($conflictos) {
                return back()->withInput()->withErrors($conflictos);
            }
        }

        // Validación de modalidad y disponibilidad de espacio
        $verificacion = $this->verificarModalidad($request);
        if ($verificacion !== true) {
            return $verificacion;
        }

        Horario::create($validated);

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

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

    public function destroy(Horario $horario)
    {
        if ($horario->estado === 'finalizado') {
            return back()->withErrors(['estado' => 'No se puede eliminar un horario finalizado.']);
        }

        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente.');
    }

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

    private function validarConflictos(array $data, int $idHorarioActual = null)
    {
        $conflictos = [];

        // Obtener horas del horario
        $hora = Hora::find($data['hora_id']);
        $horaInicio = $hora->hora_inicio;
        $horaFin = $hora->hora_fin;

        // Función para chequear solapamiento
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

        // Materia (otros paralelos)
        $queryMateria = $solapamiento(Horario::where('materia_id', $data['materia_id'])
            ->where('dia_id', $data['dia_id'])
            ->where('periodo_academico_id', $data['periodo_academico_id']));
        if ($queryMateria->exists()) {
            $conflictos['materia_id'] = 'Esta materia ya está programada en otro paralelo en el mismo horario.';
        }

        return $conflictos ?: null;
    }

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
}
