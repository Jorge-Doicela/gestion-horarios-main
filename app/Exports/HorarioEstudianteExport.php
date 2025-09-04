<?php

namespace App\Exports;

use App\Models\Horario;
use App\Models\Dia;
use App\Models\Hora;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HorarioEstudianteExport implements FromArray, WithHeadings
{
    protected $paralelo_id;

    public function __construct($paralelo_id)
    {
        $this->paralelo_id = $paralelo_id;
    }

    public function array(): array
    {
        $dias = Dia::orderBy('id')->get();
        $horas = Hora::orderBy('hora_inicio')->get();

        $horarios = Horario::with(['materia', 'docente', 'espacio', 'dia', 'hora'])
            ->where('paralelo_id', $this->paralelo_id)
            ->where('estado', 'activo')
            ->get();

        $horarios_matriz = [];
        foreach ($horarios as $h) {
            $horarios_matriz[$h->hora_id][$h->dia_id] = $h;
        }

        $data = [];
        foreach ($horas as $hora) {
            $fila = [\Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') . ' - ' . \Carbon\Carbon::parse($hora->hora_fin)->format('H:i')];
            foreach ($dias as $dia) {
                $clase = $horarios_matriz[$hora->id][$dia->id] ?? null;
                if ($clase) {
                    $fila[] = $clase->materia->nombre . ' / ' . $clase->docente->nombre;
                } else {
                    $fila[] = '-';
                }
            }
            $data[] = $fila;
        }

        return $data;
    }

    public function headings(): array
    {
        $dias = Dia::orderBy('id')->get();
        $cabecera = ['Hora / Día'];
        foreach ($dias as $dia) {
            $cabecera[] = $dia->nombre;
        }
        return $cabecera;
    }
}
