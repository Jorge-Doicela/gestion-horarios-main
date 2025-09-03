<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GeneradorHorarioController;
use App\Http\Controllers\Api\HorarioApiController;
use App\Http\Controllers\Api\ConflictoApiController;

// Ruta para obtener información del usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas solo para Administrador
|--------------------------------------------------------------------------
| - Generar horarios automáticos
| - Cualquier otra acción de administración futura
*/
Route::middleware(['auth:sanctum', 'role:Administrador'])->group(function () {
    Route::post('/generar-horarios', [GeneradorHorarioController::class, 'generar']);
});

/*
|--------------------------------------------------------------------------
| Rutas accesibles para cualquier usuario autenticado
|--------------------------------------------------------------------------
| - Consultar horarios
| - Consultar conflictos
| - Se puede filtrar por periodo académico usando query ?periodo_id=1
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/horarios', [HorarioApiController::class, 'index']);
    Route::get('/conflictos', [ConflictoApiController::class, 'index']);
});
