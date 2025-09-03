<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Nivel;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::with(['carrera', 'nivel'])->paginate(10);
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        $niveles = Nivel::all();
        return view('materias.create', compact('carreras', 'niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias',
            'carrera_id' => 'required|exists:carreras,id',
            'nivel_id' => 'required|exists:niveles,id',
            'creditos' => 'required|integer|min:0',
            'tipo' => 'required|in:teorica,practica,mixta',
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia)
    {
        $carreras = Carrera::all();
        $niveles = Nivel::all();
        return view('materias.edit', compact('materia', 'carreras', 'niveles'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias,codigo,' . $materia->id,
            'carrera_id' => 'required|exists:carreras,id',
            'nivel_id' => 'required|exists:niveles,id',
            'creditos' => 'required|integer|min:0',
            'tipo' => 'required|in:teorica,practica,mixta',
        ]);

        $materia->update($request->all());

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia)
    {
        $materia->delete();
        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }
}
