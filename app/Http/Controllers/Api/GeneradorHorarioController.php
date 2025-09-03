<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeneradorHorarios;
use App\Models\PeriodoAcademico;

class GeneradorHorarioController extends Controller
{
    /**
     * Generar horarios para un periodo académico específico.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generar(Request $request)
    {
        // Validación de entrada
        $validated = $request->validate([
            'periodo_id' => 'required|exists:periodos_academicos,id',
        ]);

        // Buscar el periodo académico
        $periodo = PeriodoAcademico::findOrFail($validated['periodo_id']);

        // Crear instancia del servicio generador de horarios
        $generador = new GeneradorHorarios($periodo);

        // Ejecutar generación
        $resultado = $generador->generar();

        // Retornar resultado como JSON con estructura detallada
        return response()->json([
            'status' => $resultado['status'] ?? 'success',
            'horarios_generados' => $resultado['horarios_generados'] ?? 0,
            'conflictos' => $resultado['conflictos'] ?? 0,
            'mensaje' => $resultado['mensaje'] ?? 'Horarios generados correctamente',
        ]);
    }
}
