<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // Protegemos todas las rutas con permisos de Spatie
        $this->middleware(['auth', 'role:Administrador']);
    }

    /**
     * Listar usuarios
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guardar usuario
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles'    => 'required|array',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Asignar roles
        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray(); // <-- roles del usuario como array de nombres
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }


    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $user)
    {
        // ⚠️ Evitar que un admin se quite a sí mismo el rol de Administrador
        if ($user->hasRole('Administrador') && auth()->id() === $user->id && !in_array('Administrador', $request->roles ?? [])) {
            return redirect()->back()->withErrors(['roles' => 'No puedes quitarte tu propio rol de Administrador.']);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles'    => 'required|array',
        ]);

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        // ⚠️ Proteger el rol "Administrador" de ser quitado a otros Admins por error
        if ($user->hasRole('Administrador') && !in_array('Administrador', $validated['roles'])) {
            return redirect()->back()->withErrors(['roles' => 'No puedes quitar el rol Administrador de este usuario.']);
        }

        $user->syncRoles($validated['roles']);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $user)
    {
        // ⚠️ Evitar que un admin se borre a sí mismo
        if (auth()->id() === $user->id) {
            return redirect()->back()->withErrors(['user' => 'No puedes eliminar tu propio usuario.']);
        }

        // ⚠️ Evitar eliminar al Administrador principal
        if ($user->hasRole('Administrador')) {
            return redirect()->back()->withErrors(['user' => 'No puedes eliminar un usuario con rol Administrador.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
