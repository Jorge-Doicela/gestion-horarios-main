<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    // Mostrar todas las carreras
    public function index()
    {
        $carreras = Carrera::paginate(10);
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
            'descripcion' => 'nullable|string',
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
            'descripcion' => 'nullable|string',
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
