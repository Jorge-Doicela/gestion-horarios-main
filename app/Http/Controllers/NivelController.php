<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index(Request $request)
    {
        $query = Nivel::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nombre', 'like', "%{$search}%");
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $niveles = $query->paginate(15)->withQueryString();

        return view('niveles.index', compact('niveles'));
    }

    public function create()
    {
        return view('niveles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:niveles,nombre',
        ], [
            'nombre.required' => 'El nombre del nivel es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre.unique' => 'Ya existe un nivel con este nombre.',
        ]);

        Nivel::create($request->all());

        return redirect()->route('niveles.index')
            ->with('success', 'Nivel académico creado correctamente.');
    }

    public function edit(Nivel $nivel)
    {
        return view('niveles.edit', compact('nivel'));
    }

    public function update(Request $request, Nivel $nivel)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:niveles,nombre,' . $nivel->id,
        ], [
            'nombre.required' => 'El nombre del nivel es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 50 caracteres.',
            'nombre.unique' => 'Ya existe un nivel con este nombre.',
        ]);

        $nivel->update($request->all());

        return redirect()->route('niveles.index')
            ->with('success', 'Nivel académico actualizado correctamente.');
    }

    public function destroy(Nivel $nivel)
    {
        $nivel->delete();

        return redirect()->route('niveles.index')
            ->with('success', 'Nivel académico eliminado correctamente.');
    }
}
