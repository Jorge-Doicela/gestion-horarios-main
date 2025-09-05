<?php

namespace App\Http\Controllers;

use App\Models\Hora;
use Illuminate\Http\Request;

class HoraController extends Controller
{
    public function index()
    {
        $horas = Hora::orderBy('hora_inicio')->paginate(20);
        return view('admin.catalogos.horas.index', compact('horas'));
    }

    public function create()
    {
        return view('admin.catalogos.horas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);
        Hora::create($data);
        return redirect()->route('admin.horas.index')->with('success', 'Franja horaria creada.');
    }

    public function edit(Hora $hora)
    {
        return view('admin.catalogos.horas.edit', compact('hora'));
    }

    public function update(Request $request, Hora $hora)
    {
        $data = $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);
        $hora->update($data);
        return redirect()->route('admin.horas.index')->with('success', 'Franja horaria actualizada.');
    }

    public function destroy(Hora $hora)
    {
        $hora->delete();
        return redirect()->route('admin.horas.index')->with('success', 'Franja horaria eliminada.');
    }
}
