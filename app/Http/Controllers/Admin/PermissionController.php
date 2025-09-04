<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        // Todas las rutas protegidas solo para usuarios con rol 'Administrador'
        $this->middleware(['auth', 'role:Administrador']);
    }

    /**
     * Listar permisos con paginación, filtros y búsqueda
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $permissions = $query->paginate(15)->withQueryString();

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Guardar un nuevo permiso
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        Permission::create(['name' => $data['name']]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permiso creado correctamente.');
    }

    /**
     * Redirigir show a edit
     */
    public function show(Permission $permission)
    {
        return redirect()->route('admin.permissions.edit', $permission);
    }

    /**
     * Formulario de edición
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Actualizar permiso
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ], [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.string' => 'El nombre debe ser texto.',
            'name.max' => 'El nombre no puede exceder los 255 caracteres.',
            'name.unique' => 'Ya existe un permiso con este nombre.',
        ]);

        $permission->update(['name' => $data['name']]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permiso actualizado correctamente.');
    }

    /**
     * Eliminar permiso
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
