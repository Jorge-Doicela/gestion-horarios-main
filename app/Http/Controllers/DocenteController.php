<?php
// app/Http/Controllers/DocenteController.php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('materias')->paginate(10);
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        $materias = Materia::all();
        return view('docentes.create', compact('materias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|unique:docentes,email',
            'titulo' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'materias' => 'nullable|array'
        ]);

        $docente = Docente::create($validated);
        $docente->materias()->sync($validated['materias'] ?? []);

        return redirect()->route('docentes.index')->with('success', 'Docente creado correctamente');
    }

    public function edit(Docente $docente)
    {
        $materias = Materia::all();
        $materiasSeleccionadas = $docente->materias->pluck('id')->toArray();
        return view('docentes.edit', compact('docente', 'materias', 'materiasSeleccionadas'));
    }

    public function update(Request $request, Docente $docente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'nullable|email|unique:docentes,email,' . $docente->id,
            'titulo' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'materias' => 'nullable|array'
        ]);

        $docente->update($validated);
        $docente->materias()->sync($validated['materias'] ?? []);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente');
    }
}
