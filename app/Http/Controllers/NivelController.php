<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        $niveles = Nivel::paginate(10);
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
