<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use Illuminate\Http\Request;

class DiaController extends Controller
{
    public function index()
    {
        $dias = Dia::orderBy('id')->paginate(20);
        return view('admin.catalogos.dias.index', compact('dias'));
    }

    public function create()
    {
        return view('admin.catalogos.dias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nombre' => 'required|string|max:50|unique:dias,nombre']);
        Dia::create($data);
        return redirect()->route('admin.dias.index')->with('success', 'Día creado.');
    }

    public function edit(Dia $dia)
    {
        return view('admin.catalogos.dias.edit', compact('dia'));
    }

    public function update(Request $request, Dia $dia)
    {
        $data = $request->validate(['nombre' => 'required|string|max:50|unique:dias,nombre,' . $dia->id]);
        $dia->update($data);
        return redirect()->route('admin.dias.index')->with('success', 'Día actualizado.');
    }

    public function destroy(Dia $dia)
    {
        $dia->delete();
        return redirect()->route('admin.dias.index')->with('success', 'Día eliminado.');
    }
}
