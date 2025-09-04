<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PeriodoAcademico;

class PeriodoAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodos = [
            [
                'nombre' => 'Primer Semestre 2024',
                'fecha_inicio' => '2024-01-15',
                'fecha_fin' => '2024-06-15',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Segundo Semestre 2024',
                'fecha_inicio' => '2024-08-15',
                'fecha_fin' => '2024-12-15',
                'estado' => 'activo'
            ],
            [
                'nombre' => 'Primer Semestre 2025',
                'fecha_inicio' => '2025-01-15',
                'fecha_fin' => '2025-06-15',
                'estado' => 'activo'
            ]
        ];

        foreach ($periodos as $periodo) {
            PeriodoAcademico::create($periodo);
        }
    }
}