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

// Rutas personalizadas de horarios - deben ir **antes** del resource
Route::middleware(['auth', 'role:Administrador|Coordinador Académico'])->group(function () {
    Route::get('/horarios/calendario', [HorarioController::class, 'calendario'])->name('horarios.calendario');
    Route::post('/horarios/generar', [HorarioController::class, 'generarAutomatico'])->name('horarios.generar');

    // Cambio de estado de un horario (opcional)
    Route::patch('/horarios/{horario}/cambiar-estado/{estado}', [HorarioController::class, 'cambiarEstado'])
        ->name('horarios.cambiarEstado');
});

// CRUD de horarios excluyendo show
Route::middleware('auth')->group(function () {
    Route::resource('horarios', HorarioController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación Laravel Breeze
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
