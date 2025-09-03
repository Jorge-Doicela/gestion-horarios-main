<?php

namespace App\Http\Controllers;

use App\Models\PeriodoAcademico;
use Illuminate\Http\Request;

class PeriodoAcademicoController extends Controller
{
    public function index()
    {
        $periodos = PeriodoAcademico::orderBy('fecha_inicio', 'desc')->get();
        return view('periodos.index', compact('periodos'));
    }

    public function create()
    {
        return view('periodos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        PeriodoAcademico::create($request->all());
        return redirect()->route('periodos.index')->with('success', 'Periodo académico creado correctamente.');
    }

    public function edit(PeriodoAcademico $periodo)
    {
        return view('periodos.edit', compact('periodo'));
    }

    public function update(Request $request, PeriodoAcademico $periodo)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:activo,inactivo,finalizado',
        ]);

        $periodo->update($request->all());
        return redirect()->route('periodos.index')->with('success', 'Periodo académico actualizado correctamente.');
    }

    public function destroy(PeriodoAcademico $periodo)
    {
        $periodo->delete();
        return redirect()->route('periodos.index')->with('success', 'Periodo académico eliminado correctamente.');
    }
}
