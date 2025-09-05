<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SimulacionExport implements FromArray, WithHeadings, WithStyles
{
    protected $periodo;
    protected $resultado;

    public function __construct($periodo, array $resultado)
    {
        $this->periodo = $periodo;
        $this->resultado = $resultado;
    }

    public function array(): array
    {
        $rows = [];
        foreach (($this->resultado['propuestas'] ?? []) as $p) {
            $rows[] = [
                $p['materia'] ?? '',
                $p['docente'] ?? '',
                $p['paralelo'] ?? '',
                $p['dia'] ?? '',
                $p['hora'] ?? '',
                $p['espacio'] ?? '',
                ucfirst($p['modalidad'] ?? ''),
            ];
        }
        return $rows;
    }

    public function headings(): array
    {
        return ['MATERIA', 'DOCENTE', 'PARALELO', 'DÍA', 'HORA', 'ESPACIO', 'MODALIDAD'];
    }

    public function styles(Worksheet $sheet)
    {
        // Encabezados en negrita y con fondo
        $sheet->getStyle('A1:G1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF1F4E79');
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        return [];
    }
}
