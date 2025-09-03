<?php

namespace App\Http\Controllers;

use App\Models\Restriccion;
use App\Models\Docente;
use App\Models\Espacio;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;

class RestriccionController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->get('tipo');
        $query = Restriccion::query();

        if ($tipo) {
            $query->where('tipo', $tipo);
        }

        $restricciones = $query->paginate(10);

        return view('restricciones.index', compact('restricciones', 'tipo'));
    }

    public function create()
    {
        $tipos = ['docente', 'aula', 'materia', 'estudiante'];
        $docentes = Docente::all();
        $aulas = Espacio::all();
        $materias = Materia::all();
        $estudiantes = User::where('role', 'estudiante')->get();

        return view('restricciones.create', compact('tipos', 'docentes', 'aulas', 'materias', 'estudiantes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tipo' => 'required|in:docente,aula,materia,estudiante',
            'referencia_id' => 'required|integer',
            'clave' => 'required|string|max:50',
            'valor' => 'required|string',
        ]);

        // Validar existencia de referencia
        $this->validarReferencia($request->tipo, $request->referencia_id);

        Restriccion::create($request->all());

        return redirect()->route('restricciones.index')->with('success', 'Restricción creada correctamente.');
    }

    public function edit($id)
    {
        $restriccion = Restriccion::findOrFail($id);

        $tipos = ['docente', 'aula', 'materia', 'estudiante'];
        $docentes = Docente::all();
        $aulas = Espacio::all();
        $materias = Materia::all();
        $estudiantes = User::where('role', 'estudiante')->get();

        return view('restricciones.edit', compact('restriccion', 'tipos', 'docentes', 'aulas', 'materias', 'estudiantes'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tipo' => 'required|in:docente,aula,materia,estudiante',
            'referencia_id' => 'required|integer',
            'clave' => 'required|string|max:50',
            'valor' => 'required|string',
        ]);

        $this->validarReferencia($request->tipo, $request->referencia_id);

        $restriccion = Restriccion::findOrFail($id);
        $restriccion->update($request->all());

        return redirect()->route('restricciones.index')->with('success', 'Restricción actualizada correctamente.');
    }

    public function destroy($id)
    {
        $restriccion = Restriccion::findOrFail($id);
        $restriccion->delete();

        return redirect()->route('restricciones.index')->with('success', 'Restricción eliminada correctamente.');
    }

    private function validarReferencia($tipo, $referencia_id)
    {
        switch ($tipo) {
            case 'docente':
                if (!Docente::find($referencia_id)) abort(404, "Docente no encontrado");
                break;
            case 'aula':
                if (!Espacio::find($referencia_id)) abort(404, "Aula no encontrada");
                break;
            case 'materia':
                if (!Materia::find($referencia_id)) abort(404, "Materia no encontrada");
                break;
            case 'estudiante':
                if (!User::where('id', $referencia_id)->where('role', 'estudiante')->first()) abort(404, "Estudiante no encontrado");
                break;
        }
    }
}
