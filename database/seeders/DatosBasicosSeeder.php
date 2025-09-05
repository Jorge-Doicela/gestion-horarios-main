<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dia;
use App\Models\Hora;
use App\Models\Carrera;
use App\Models\Nivel;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Espacio;
use App\Models\PeriodoAcademico;

class DatosBasicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear días de la semana
        $dias = [
            ['nombre' => 'Lunes'],
            ['nombre' => 'Martes'],
            ['nombre' => 'Miércoles'],
            ['nombre' => 'Jueves'],
            ['nombre' => 'Viernes'],
            ['nombre' => 'Sábado'],
        ];

        foreach ($dias as $dia) {
            Dia::firstOrCreate($dia);
        }

        // Crear horas del día (8:00 AM - 8:00 PM)
        $horas = [
            ['hora_inicio' => '08:00', 'hora_fin' => '09:00'],
            ['hora_inicio' => '09:00', 'hora_fin' => '10:00'],
            ['hora_inicio' => '10:00', 'hora_fin' => '11:00'],
            ['hora_inicio' => '11:00', 'hora_fin' => '12:00'],
            ['hora_inicio' => '12:00', 'hora_fin' => '13:00'],
            ['hora_inicio' => '13:00', 'hora_fin' => '14:00'],
            ['hora_inicio' => '14:00', 'hora_fin' => '15:00'],
            ['hora_inicio' => '15:00', 'hora_fin' => '16:00'],
            ['hora_inicio' => '16:00', 'hora_fin' => '17:00'],
            ['hora_inicio' => '17:00', 'hora_fin' => '18:00'],
            ['hora_inicio' => '18:00', 'hora_fin' => '19:00'],
            ['hora_inicio' => '19:00', 'hora_fin' => '20:00'],
        ];

        foreach ($horas as $hora) {
            Hora::firstOrCreate($hora);
        }

        // Crear carreras
        $carreras = [
            ['nombre' => 'Ingeniería en Sistemas', 'codigo' => 'IS', 'descripcion' => 'Carrera de Ingeniería en Sistemas'],
            ['nombre' => 'Medicina', 'codigo' => 'MED', 'descripcion' => 'Carrera de Medicina'],
            ['nombre' => 'Derecho', 'codigo' => 'DER', 'descripcion' => 'Carrera de Derecho'],
            ['nombre' => 'Administración', 'codigo' => 'ADM', 'descripcion' => 'Carrera de Administración'],
        ];

        foreach ($carreras as $carrera) {
            Carrera::firstOrCreate(['codigo' => $carrera['codigo']], $carrera);
        }

        // Crear niveles
        $niveles = [
            ['nombre' => 'Primer Nivel'],
            ['nombre' => 'Segundo Nivel'],
            ['nombre' => 'Tercer Nivel'],
            ['nombre' => 'Cuarto Nivel'],
            ['nombre' => 'Quinto Nivel'],
        ];

        foreach ($niveles as $nivel) {
            Nivel::firstOrCreate($nivel);
        }

        // Crear espacios
        $espacios = [
            ['nombre' => 'Aula 101', 'tipo' => 'aula', 'ubicacion' => 'Edificio A - Planta 1', 'disponible' => true, 'modalidad' => 'presencial', 'capacidad' => 30],
            ['nombre' => 'Aula 102', 'tipo' => 'aula', 'ubicacion' => 'Edificio A - Planta 1', 'disponible' => true, 'modalidad' => 'presencial', 'capacidad' => 35],
            ['nombre' => 'Aula 201', 'tipo' => 'aula', 'ubicacion' => 'Edificio A - Planta 2', 'disponible' => true, 'modalidad' => 'presencial', 'capacidad' => 40],
            ['nombre' => 'Laboratorio 1', 'tipo' => 'laboratorio', 'ubicacion' => 'Edificio B - Planta 1', 'disponible' => true, 'modalidad' => 'presencial', 'capacidad' => 25],
            ['nombre' => 'Auditorio', 'tipo' => 'auditorio', 'ubicacion' => 'Edificio Principal', 'disponible' => true, 'modalidad' => 'presencial', 'capacidad' => 100],
            ['nombre' => 'Virtual', 'tipo' => 'virtual', 'ubicacion' => 'Plataforma online', 'disponible' => true, 'modalidad' => 'virtual', 'capacidad' => 999],
        ];

        foreach ($espacios as $espacio) {
            Espacio::firstOrCreate(['nombre' => $espacio['nombre']], $espacio);
        }

        // Crear docentes
        $docentes = [
            ['nombre' => 'Dr. Juan Pérez', 'email' => 'juan.perez@universidad.edu', 'titulo' => 'PhD en Informática', 'especialidad' => 'Programación'],
            ['nombre' => 'Dra. María González', 'email' => 'maria.gonzalez@universidad.edu', 'titulo' => 'PhD en Medicina', 'especialidad' => 'Cardiología'],
            ['nombre' => 'Lic. Carlos Rodríguez', 'email' => 'carlos.rodriguez@universidad.edu', 'titulo' => 'Licenciado en Derecho', 'especialidad' => 'Derecho Civil'],
            ['nombre' => 'MBA Ana López', 'email' => 'ana.lopez@universidad.edu', 'titulo' => 'MBA', 'especialidad' => 'Administración'],
            ['nombre' => 'Ing. Pedro Martínez', 'email' => 'pedro.martinez@universidad.edu', 'titulo' => 'Ingeniero en Sistemas', 'especialidad' => 'Base de Datos'],
        ];

        foreach ($docentes as $docente) {
            Docente::firstOrCreate(['email' => $docente['email']], $docente);
        }

        // Crear paralelos para cada carrera y nivel
        $carreras = Carrera::all();
        $niveles = Nivel::all();

        foreach ($carreras as $carrera) {
            foreach ($niveles as $nivel) {
                Paralelo::firstOrCreate([
                    'carrera_id' => $carrera->id,
                    'nivel_id' => $nivel->id,
                    'nombre' => "A-{$carrera->codigo}"
                ]);
            }
        }

        // Crear materias
        $materias = [
            // Ingeniería en Sistemas
            ['nombre' => 'Programación I', 'codigo' => 'IS101', 'carrera_id' => 1, 'nivel_id' => 1, 'creditos' => 3, 'tipo' => 'practica'],
            ['nombre' => 'Matemáticas I', 'codigo' => 'IS102', 'carrera_id' => 1, 'nivel_id' => 1, 'creditos' => 4, 'tipo' => 'teorica'],
            ['nombre' => 'Base de Datos', 'codigo' => 'IS201', 'carrera_id' => 1, 'nivel_id' => 2, 'creditos' => 4, 'tipo' => 'mixta'],

            // Medicina
            ['nombre' => 'Anatomía I', 'codigo' => 'MED101', 'carrera_id' => 2, 'nivel_id' => 1, 'creditos' => 5, 'tipo' => 'teorica'],
            ['nombre' => 'Fisiología', 'codigo' => 'MED102', 'carrera_id' => 2, 'nivel_id' => 1, 'creditos' => 4, 'tipo' => 'teorica'],

            // Derecho
            ['nombre' => 'Derecho Civil I', 'codigo' => 'DER101', 'carrera_id' => 3, 'nivel_id' => 1, 'creditos' => 3, 'tipo' => 'teorica'],
            ['nombre' => 'Derecho Penal', 'codigo' => 'DER201', 'carrera_id' => 3, 'nivel_id' => 2, 'creditos' => 4, 'tipo' => 'teorica'],

            // Administración
            ['nombre' => 'Contabilidad I', 'codigo' => 'ADM101', 'carrera_id' => 4, 'nivel_id' => 1, 'creditos' => 3, 'tipo' => 'practica'],
            ['nombre' => 'Gestión Empresarial', 'codigo' => 'ADM201', 'carrera_id' => 4, 'nivel_id' => 2, 'creditos' => 4, 'tipo' => 'teorica'],
        ];

        foreach ($materias as $materia) {
            Materia::firstOrCreate(['codigo' => $materia['codigo']], $materia);
        }

        // Asignar docentes a materias
        $this->asignarDocentesAMaterias();

        // Crear período académico
        PeriodoAcademico::firstOrCreate([
            'nombre' => '2024-2025'
        ], [
            'fecha_inicio' => '2024-09-01',
            'fecha_fin' => '2025-06-30',
            'estado' => 'activo'
        ]);
    }

    private function asignarDocentesAMaterias()
    {
        // Obtener docentes y materias
        $juan = Docente::where('email', 'juan.perez@universidad.edu')->first();
        $maria = Docente::where('email', 'maria.gonzalez@universidad.edu')->first();
        $carlos = Docente::where('email', 'carlos.rodriguez@universidad.edu')->first();
        $ana = Docente::where('email', 'ana.lopez@universidad.edu')->first();
        $pedro = Docente::where('email', 'pedro.martinez@universidad.edu')->first();

        // Asignar materias a docentes
        if ($juan) {
            $juan->materias()->sync([
                Materia::where('codigo', 'IS101')->first()?->id,
                Materia::where('codigo', 'IS102')->first()?->id,
            ]);
        }

        if ($pedro) {
            $pedro->materias()->sync([
                Materia::where('codigo', 'IS201')->first()?->id,
            ]);
        }

        if ($maria) {
            $maria->materias()->sync([
                Materia::where('codigo', 'MED101')->first()?->id,
                Materia::where('codigo', 'MED102')->first()?->id,
            ]);
        }

        if ($carlos) {
            $carlos->materias()->sync([
                Materia::where('codigo', 'DER101')->first()?->id,
                Materia::where('codigo', 'DER201')->first()?->id,
            ]);
        }

        if ($ana) {
            $ana->materias()->sync([
                Materia::where('codigo', 'ADM101')->first()?->id,
                Materia::where('codigo', 'ADM201')->first()?->id,
            ]);
        }
    }
}
