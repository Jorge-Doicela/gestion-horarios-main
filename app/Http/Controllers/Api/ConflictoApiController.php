<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conflicto;
use Illuminate\Http\Request;

class ConflictoApiController extends Controller
{
    public function index(Request $request)
    {
        $periodo_id = $request->query('periodo_id');

        $conflictos = Conflicto::when($periodo_id, function ($q) use ($periodo_id) {
            $q->whereHas('horario', fn($query) => $query->where('periodo_academico_id', $periodo_id));
        })->get();

        return response()->json([
            'status' => 'ok',
            'conflictos' => $conflictos
        ]);
    }
}
