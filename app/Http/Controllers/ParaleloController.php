<?php
// app/Http/Controllers/ParaleloController.php

namespace App\Http\Controllers;

use App\Models\Paralelo;
use App\Models\Carrera;
use App\Models\Nivel;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index()
    {
        $paralelos = Paralelo::with(['carrera', 'nivel'])->get();
        return view('paralelos.index', compact('paralelos'));
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
