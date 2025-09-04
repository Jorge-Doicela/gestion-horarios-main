<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Espacio;

class EspacioController extends Controller
{
    public function index(Request $request)
    {
        $query = Espacio::query();

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('modalidad')) {
            $query->where('modalidad', $request->modalidad);
        }

        if ($request->filled('disponible')) {
            $query->where('disponible', $request->disponible === '1');
        }

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('ubicacion', 'like', "%{$search}%")
                  ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'nombre');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $espacios = $query->paginate(15)->withQueryString();

        // Datos para filtros
        $tipos = ['aula', 'laboratorio', 'cancha', 'aula interactiva', 'otro'];
        $modalidades = ['presencial', 'virtual', 'hibrida'];

        return view('espacios.index', compact('espacios', 'tipos', 'modalidades'));
    }

    public function create()
    {
        return view('espacios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:espacios,nombre',
            'tipo' => 'required|in:aula,laboratorio,cancha,aula interactiva,otro',
            'ubicacion' => 'nullable|string|max:255',
            'disponible' => 'required|boolean',
            'modalidad' => 'required|in:presencial,virtual,hibrida',
            'capacidad' => 'nullable|integer|min:1|max:1000',
            'equipamiento' => 'nullable|array',
        ], [
            'nombre.required' => 'El nombre del espacio es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre.unique' => 'Ya existe un espacio con este nombre.',
            'tipo.required' => 'El tipo de espacio es obligatorio.',
            'tipo.in' => 'El tipo debe ser: aula, laboratorio, cancha, aula interactiva u otro.',
            'ubicacion.string' => 'La ubicación debe ser texto.',
            'ubicacion.max' => 'La ubicación no puede exceder los 255 caracteres.',
            'disponible.required' => 'Debe especificar si el espacio está disponible.',
            'disponible.boolean' => 'La disponibilidad debe ser verdadero o falso.',
            'modalidad.required' => 'La modalidad es obligatoria.',
            'modalidad.in' => 'La modalidad debe ser: presencial, virtual o híbrida.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
            'capacidad.max' => 'La capacidad no puede exceder 1000.',
            'equipamiento.array' => 'El equipamiento debe ser una lista.',
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
