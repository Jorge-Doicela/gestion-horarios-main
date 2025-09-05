<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Crear usuario administrador
        $admin = User::firstOrCreate([
            'email' => 'admin@horarios.com'
        ], [
            'name' => 'Administrador',
            'password' => Hash::make('admin123'),
        ]);

        // Asignar rol de administrador
        $adminRole = Role::where('name', 'Administrador')->first();
        if ($adminRole && !$admin->hasRole('Administrador')) {
            $admin->assignRole($adminRole);
        }

        echo "Usuario administrador creado:\n";
        echo "Email: admin@horarios.com\n";
        echo "Password: admin123\n";
    }
}
