<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        // Protege todas las rutas del controlador solo para administradores
        $this->middleware(['auth', 'role:Administrador']);
    }

    /**
     * Mostrar todos los roles
     */
    public function index(Request $request)
    {
        $query = Role::with('permissions');

        // Filtro por búsqueda de nombre
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Filtro opcional por número mínimo de permisos
        if ($request->filled('min_permissions')) {
            $min = (int) $request->input('min_permissions');
            $query->withCount('permissions')->having('permissions_count', '>=', $min);
        }

        // Ordenar por nombre ascendente
        $roles = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.roles.index', compact('roles'));
    }


    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Guardar un nuevo rol
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:50',
            'permissions' => 'nullable|array',
        ]);

        // No permitir crear un rol con nombre reservado
        if (in_array(strtolower($request->name), ['administrador', 'super-admin'])) {
            return redirect()->back()->withErrors(['name' => 'Este nombre de rol está reservado.']);
        }

        $role = Role::create([
            'name' => ucfirst(strtolower($request->name)),
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Role $role)
    {
        // Bloquear edición del rol Administrador
        if ($role->name === 'Administrador') {
            return redirect()->route('admin.roles.index')->withErrors('El rol Administrador no se puede editar.');
        }

        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Actualizar rol
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Administrador') {
            return redirect()->route('admin.roles.index')->withErrors('El rol Administrador no se puede modificar.');
        }

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        // Evitar renombrar a nombres reservados
        if (in_array(strtolower($request->name), ['administrador', 'super-admin'])) {
            return redirect()->back()->withErrors(['name' => 'Este nombre de rol está reservado.']);
        }

        $role->update([
            'name' => ucfirst(strtolower($request->name)),
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Eliminar un rol
     */
    public function destroy(Role $role)
    {
        if ($role->name === 'Administrador') {
            return redirect()->route('admin.roles.index')->withErrors('El rol Administrador no se puede eliminar.');
        }

        // Evitar eliminar un rol asignado a usuarios
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->withErrors('No se puede eliminar un rol que está asignado a usuarios.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
