<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioApiController extends Controller
{
    public function index(Request $request)
    {
        $periodo_id = $request->query('periodo_id');

        $horarios = Horario::with(['materia', 'docente', 'espacio', 'dia', 'hora'])
            ->when($periodo_id, fn($q) => $q->where('periodo_academico_id', $periodo_id))
            ->get();

        return response()->json([
            'status' => 'ok',
            'horarios' => $horarios
        ]);
    }
}
