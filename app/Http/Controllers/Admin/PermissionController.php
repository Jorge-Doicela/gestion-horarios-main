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
     * Listar permisos
     */
    public function index()
    {
        $permissions = Permission::paginate(10);
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
            'name' => 'required|string|unique:permissions,name',
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
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
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
