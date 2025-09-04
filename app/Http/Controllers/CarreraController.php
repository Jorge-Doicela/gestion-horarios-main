<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    // Mostrar todas las carreras con paginación, filtros y búsqueda
    public function index(Request $request)
    {
        $query = Carrera::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $carreras = $query->paginate(15)->withQueryString();

        return view('carreras.index', compact('carreras'));
    }

    // Formulario para crear
    public function create()
    {
        return view('carreras.create');
    }

    // Guardar nueva carrera
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:carreras,codigo',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'codigo.required' => 'El código de la carrera es obligatorio.',
            'codigo.string' => 'El código debe ser texto.',
            'codigo.max' => 'El código no puede exceder los 20 caracteres.',
            'codigo.unique' => 'Ya existe una carrera con este código.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
        ]);

        Carrera::create($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera creada correctamente.');
    }

    // Formulario para editar
    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    // Actualizar carrera
    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:carreras,codigo,' . $carrera->id,
            'descripcion' => 'nullable|string|max:500',
        ], [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'codigo.required' => 'El código de la carrera es obligatorio.',
            'codigo.string' => 'El código debe ser texto.',
            'codigo.max' => 'El código no puede exceder los 20 caracteres.',
            'codigo.unique' => 'Ya existe una carrera con este código.',
            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede exceder los 500 caracteres.',
        ]);

        $carrera->update($request->all());

        return redirect()->route('carreras.index')
            ->with('success', 'Carrera actualizada correctamente.');
    }

    // Eliminar carrera
    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')
            ->with('success', 'Carrera eliminada correctamente.');
    }
}
