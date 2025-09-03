<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Espacio;

class EspacioController extends Controller
{
    public function index()
    {
        $espacios = Espacio::orderBy('nombre')->paginate(10);
        return view('espacios.index', compact('espacios'));
    }

    public function create()
    {
        return view('espacios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:aula,laboratorio,cancha,aula interactiva,otro',
            'ubicacion' => 'nullable|string|max:255',
            'disponible' => 'required|boolean',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'capacidad' => 'nullable|integer|min:0',
            'equipamiento' => 'nullable|array',
        ]);

        Espacio::create($validated);

        return redirect()->route('espacios.index')
            ->with('success', 'Espacio creado correctamente.');
    }

    public function edit(Espacio $espacio)
    {
        return view('espacios.edit', compact('espacio'));
    }

    public function update(Request $request, Espacio $espacio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:aula,laboratorio,cancha,aula interactiva,otro',
            'ubicacion' => 'nullable|string|max:255',
            'disponible' => 'required|boolean',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'capacidad' => 'nullable|integer|min:0',
            'equipamiento' => 'nullable|array',
        ]);

        $espacio->update($validated);

        return redirect()->route('espacios.index')
            ->with('success', 'Espacio actualizado correctamente.');
    }

    public function destroy(Espacio $espacio)
    {
        $espacio->delete();
        return redirect()->route('espacios.index')
            ->with('success', 'Espacio eliminado correctamente.');
    }
}
