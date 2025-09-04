<?php
// app/Http/Controllers/DocenteController.php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index(Request $request)
    {
        $query = Docente::with('materias');

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('titulo', 'like', "%{$search}%")
                  ->orWhere('especialidad', 'like', "%{$search}%")
                  ->orWhereHas('materias', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por especialidad
        if ($request->filled('especialidad')) {
            $query->where('especialidad', 'like', "%{$request->especialidad}%");
        }

        // Filtro por materia
        if ($request->filled('materia_id')) {
            $query->whereHas('materias', function ($q) use ($request) {
                $q->where('materias.id', $request->materia_id);
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $docentes = $query->paginate(15)->withQueryString();

        // Obtener datos para filtros
        $materias = Materia::orderBy('nombre')->get();
        $especialidades = Docente::whereNotNull('especialidad')
            ->distinct()
            ->pluck('especialidad')
            ->filter()
            ->sort()
            ->values();

        return view('docentes.index', compact('docentes', 'materias', 'especialidades'));
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
        ], [
            'nombre.required' => 'El nombre del docente es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Ya existe un docente con este email.',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no puede exceder los 100 caracteres.',
            'especialidad.string' => 'La especialidad debe ser texto.',
            'especialidad.max' => 'La especialidad no puede exceder los 100 caracteres.',
            'materias.array' => 'Las materias deben ser una lista válida.',
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
        ], [
            'nombre.required' => 'El nombre del docente es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Ya existe un docente con este email.',
            'titulo.string' => 'El título debe ser texto.',
            'titulo.max' => 'El título no puede exceder los 100 caracteres.',
            'especialidad.string' => 'La especialidad debe ser texto.',
            'especialidad.max' => 'La especialidad no puede exceder los 100 caracteres.',
            'materias.array' => 'Las materias deben ser una lista válida.',
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
