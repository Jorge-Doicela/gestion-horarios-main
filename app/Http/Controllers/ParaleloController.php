<?php
// app/Http/Controllers/ParaleloController.php

namespace App\Http\Controllers;

use App\Models\Paralelo;
use App\Models\Carrera;
use App\Models\Nivel;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index(Request $request)
    {
        $query = Paralelo::with(['carrera', 'nivel']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhereHas('carrera', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  })
                  ->orWhereHas('nivel', function ($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por carrera
        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        // Filtro por nivel
        if ($request->filled('nivel_id')) {
            $query->where('nivel_id', $request->nivel_id);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $paralelos = $query->paginate(15)->withQueryString();

        // Obtener datos para filtros
        $carreras = Carrera::orderBy('nombre')->get();
        $niveles = Nivel::orderBy('nombre')->get();

        return view('paralelos.index', compact('paralelos', 'carreras', 'niveles'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        $niveles = Nivel::all();
        return view('paralelos.create', compact('carreras', 'niveles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:20',
            'carrera_id' => 'required|exists:carreras,id',
            'nivel_id' => 'required|exists:niveles,id',
        ], [
            'nombre.required' => 'El nombre del paralelo es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 20 caracteres.',
            'carrera_id.required' => 'Debe seleccionar una carrera.',
            'carrera_id.exists' => 'La carrera seleccionada no existe.',
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'nivel_id.exists' => 'El nivel seleccionado no existe.',
        ]);

        Paralelo::create($request->all());

        return redirect()->route('paralelos.index')->with('success', 'Paralelo creado con éxito.');
    }

    public function edit(Paralelo $paralelo)
    {
        $carreras = Carrera::all();
        $niveles = Nivel::all();
        return view('paralelos.edit', compact('paralelo', 'carreras', 'niveles'));
    }

    public function update(Request $request, Paralelo $paralelo)
    {
        $request->validate([
            'nombre' => 'required|string|max:20',
            'carrera_id' => 'required|exists:carreras,id',
            'nivel_id' => 'required|exists:niveles,id',
        ], [
            'nombre.required' => 'El nombre del paralelo es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 20 caracteres.',
            'carrera_id.required' => 'Debe seleccionar una carrera.',
            'carrera_id.exists' => 'La carrera seleccionada no existe.',
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'nivel_id.exists' => 'El nivel seleccionado no existe.',
        ]);

        $paralelo->update($request->all());

        return redirect()->route('paralelos.index')->with('success', 'Paralelo actualizado con éxito.');
    }

    public function destroy(Paralelo $paralelo)
    {
        $paralelo->delete();
        return redirect()->route('paralelos.index')->with('success', 'Paralelo eliminado con éxito.');
    }
}
