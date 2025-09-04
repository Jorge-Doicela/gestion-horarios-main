<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Nivel;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Materia::with(['carrera', 'nivel']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
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

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $materias = $query->paginate(15)->withQueryString();

        // Obtener datos para filtros
        $carreras = Carrera::orderBy('nombre')->get();
        $niveles = Nivel::orderBy('nombre')->get();

        return view('materias.index', compact('materias', 'carreras', 'niveles'));
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
            'codigo' => 'required|string|max:20|unique:materias,codigo',
            'carrera_id' => 'required|exists:carreras,id',
            'nivel_id' => 'required|exists:niveles,id',
            'creditos' => 'required|integer|min:0|max:10',
            'tipo' => 'required|in:teorica,practica,mixta',
        ], [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'codigo.required' => 'El código de la materia es obligatorio.',
            'codigo.string' => 'El código debe ser texto.',
            'codigo.max' => 'El código no puede exceder los 20 caracteres.',
            'codigo.unique' => 'Ya existe una materia con este código.',
            'carrera_id.required' => 'Debe seleccionar una carrera.',
            'carrera_id.exists' => 'La carrera seleccionada no existe.',
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'nivel_id.exists' => 'El nivel seleccionado no existe.',
            'creditos.required' => 'Los créditos son obligatorios.',
            'creditos.integer' => 'Los créditos deben ser un número entero.',
            'creditos.min' => 'Los créditos no pueden ser negativos.',
            'creditos.max' => 'Los créditos no pueden exceder 10.',
            'tipo.required' => 'Debe seleccionar un tipo de materia.',
            'tipo.in' => 'El tipo de materia seleccionado no es válido.',
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
            'creditos' => 'required|integer|min:0|max:10',
            'tipo' => 'required|in:teorica,practica,mixta',
        ], [
            'nombre.required' => 'El nombre de la materia es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'codigo.required' => 'El código de la materia es obligatorio.',
            'codigo.string' => 'El código debe ser texto.',
            'codigo.max' => 'El código no puede exceder los 20 caracteres.',
            'codigo.unique' => 'Ya existe una materia con este código.',
            'carrera_id.required' => 'Debe seleccionar una carrera.',
            'carrera_id.exists' => 'La carrera seleccionada no existe.',
            'nivel_id.required' => 'Debe seleccionar un nivel.',
            'nivel_id.exists' => 'El nivel seleccionado no existe.',
            'creditos.required' => 'Los créditos son obligatorios.',
            'creditos.integer' => 'Los créditos deben ser un número entero.',
            'creditos.min' => 'Los créditos no pueden ser negativos.',
            'creditos.max' => 'Los créditos no pueden exceder 10.',
            'tipo.required' => 'Debe seleccionar un tipo de materia.',
            'tipo.in' => 'El tipo de materia seleccionado no es válido.',
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
