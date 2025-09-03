<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar solo el seeder unificado
        $this->call(RolesAndPermissionsSeeder::class);
    }
}
