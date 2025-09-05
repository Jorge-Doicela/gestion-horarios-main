<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ParaleloController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\PeriodoAcademicoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\RestriccionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Ruta de prueba para verificar que el servidor funciona
Route::get('/test', function () {
    return 'Servidor funcionando correctamente';
});

// Ruta de prueba para verificar la generación de horarios
Route::post('/test-generar', function () {
    return 'Ruta de generación funcionando correctamente';
});

// Ruta temporal sin middleware para probar la generación
Route::post('/horarios/generar-test', [HorarioController::class, 'generarAutomatico'])
    ->name('horarios.generar.test');

// Ruta para verificar períodos académicos
Route::get('/debug-periodos', function () {
    $periodos = \App\Models\PeriodoAcademico::all();
    return response()->json([
        'count' => $periodos->count(),
        'periodos' => $periodos->toArray()
    ]);
});

// Dashboard solo para usuarios autenticados y verificados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas de Perfil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas de Administración - Solo Administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('restricciones', RestriccionController::class);
        // Generador de horarios - pantalla para administradores
        Route::get('/horarios/generador', [HorarioController::class, 'generador'])
            ->name('horarios.generador');
        // CRUD de catálogo de Días y Horas
        Route::resource('dias', \App\Http\Controllers\DiaController::class);
        Route::resource('horas', \App\Http\Controllers\HoraController::class);
    });

// Carreras y Niveles - Administrador
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::resource('carreras', CarreraController::class);
    Route::resource('niveles', NivelController::class)->parameters([
        'niveles' => 'nivel'
    ]);
});

/*
|--------------------------------------------------------------------------
| Rutas de Recursos Comunes (Materias, Paralelos, Docentes, Espacios, Periodos)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::resource('materias', MateriaController::class);
    Route::resource('paralelos', ParaleloController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('espacios', EspacioController::class);
    Route::resource('periodos', PeriodoAcademicoController::class);
});

/*
|--------------------------------------------------------------------------
| Rutas de Horarios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Vista del calendario
    Route::get('/horarios/calendario', [HorarioController::class, 'calendario'])
        ->name('horarios.calendario');

    // Generación automática de horarios
    Route::post('/horarios/generar', [HorarioController::class, 'generarAutomatico'])
        ->name('horarios.generar');

    // Simulación de horarios (GET para filtros)
    Route::get('/horarios/simular', [HorarioController::class, 'simular'])
        ->name('horarios.simular');

    // Cambio de estado de un horario (opcional)
    Route::patch('/horarios/{horario}/cambiar-estado/{estado}', [HorarioController::class, 'cambiarEstado'])
        ->name('horarios.cambiarEstado');

    // Exportaciones globales
    Route::get('/horarios/export/pdf', [HorarioController::class, 'exportPDF'])
        ->name('horarios.export.pdf');
    Route::get('/horarios/export/excel', [HorarioController::class, 'exportExcel'])
        ->name('horarios.export.excel');

    // Exportaciones filtradas
    Route::get('/horarios/export/pdf-filtrado', [HorarioController::class, 'exportPDFFiltrado'])
        ->name('horarios.export.pdf.filtrado');
    Route::get('/horarios/export/excel-filtrado', [HorarioController::class, 'exportExcelFiltrado'])
        ->name('horarios.export.excel.filtrado');

    // Exportación de simulación
    Route::get('/admin/horarios/simulacion/pdf', [HorarioController::class, 'simulacionPDF'])
        ->name('admin.horarios.simulacion.pdf');
    Route::get('/admin/horarios/simulacion/excel', [HorarioController::class, 'simulacionExcel'])
        ->name('admin.horarios.simulacion.excel');

    // CRUD de horarios excluyendo show
    Route::resource('horarios', HorarioController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación Laravel Breeze
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Consulta y exportación de horario para estudiantes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Estudiante'])->group(function () {
    // Vista del horario para estudiante
    Route::get('/horarios/estudiante', [HorarioController::class, 'horarioEstudiante'])
        ->name('horarios.estudiante');

    // Exportación del horario del estudiante
    Route::get('/horario/estudiante/pdf', [HorarioController::class, 'exportPDFEstudiante'])
        ->name('horario.estudiante.pdf');
    Route::get('/horario/estudiante/excel', [HorarioController::class, 'exportExcelEstudiante'])
        ->name('horario.estudiante.excel');
});
