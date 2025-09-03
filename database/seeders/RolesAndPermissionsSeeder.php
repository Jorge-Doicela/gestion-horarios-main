<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Lista de permisos en español (uniforme)
        $permissions = [
            'gestionar usuarios',
            'gestionar roles',
            'gestionar horarios',
            'consultar horarios',
            'gestionar carreras',
            'crear horarios',
        ];

        // Crear permisos sin duplicar
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Roles oficiales y sus permisos asignados
        $rolesWithPermissions = [
            'Administrador' => Permission::all()->pluck('name')->toArray(),
            'Coordinador Académico' => ['gestionar horarios', 'consultar horarios', 'gestionar carreras'],
            'Docente' => ['consultar horarios'],
            'Estudiante' => [],
        ];

        // Crear roles y asignar permisos
        foreach ($rolesWithPermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($perms);
        }

        // Crear usuarios de ejemplo con roles oficiales
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $adminUser->assignRole('Administrador');

        $coordinadorUser = User::firstOrCreate(
            ['email' => 'coordinador@example.com'],
            ['name' => 'Coordinador User', 'password' => bcrypt('password')]
        );
        $coordinadorUser->assignRole('Coordinador Académico');

        $docenteUser = User::firstOrCreate(
            ['email' => 'docente@example.com'],
            ['name' => 'Docente User', 'password' => bcrypt('password')]
        );
        $docenteUser->assignRole('Docente');

        $estudianteUser = User::firstOrCreate(
            ['email' => 'estudiante@example.com'],
            ['name' => 'Estudiante User', 'password' => bcrypt('password')]
        );
        $estudianteUser->assignRole('Estudiante');
    }
}
