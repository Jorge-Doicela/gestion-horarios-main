<?php

namespace App\Exports;

use App\Models\Horario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Facades\Auth;

class HorariosExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $periodo_id;

    public function __construct($periodo_id)
    {
        $this->periodo_id = $periodo_id;
    }

    public function collection()
    {
        $query = Horario::with(['materia', 'paralelo', 'docente', 'espacio', 'dia', 'hora'])
            ->where('periodo_academico_id', $this->periodo_id);

        if (Auth::user()->hasRole('Docente')) {
            $query->where('docente_id', Auth::id());
        }

        return $query->get()->map(function ($h) {
            return [
                'Día' => $h->dia->nombre,
                'Hora' => $h->hora->hora_inicio . ' - ' . $h->hora->hora_fin,
                'Materia' => $h->materia->nombre,
                'Paralelo' => $h->paralelo->nombre,
                'Docente' => $h->docente->nombre,
                'Espacio' => $h->espacio?->nombre ?? 'Sin asignar',
                'Modalidad' => ucfirst($h->modalidad),
                'Estado' => ucfirst($h->estado),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Día',
            'Hora',
            'Materia',
            'Paralelo',
            'Docente',
            'Espacio',
            'Modalidad',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => 'center']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Colores por modalidad
                $rows = $sheet->getHighestRow();
                for ($row = 2; $row <= $rows; $row++) {
                    $modalidad = strtolower($sheet->getCell("G$row")->getValue());
                    $estado = strtolower($sheet->getCell("H$row")->getValue());

                    $color = 'FFFFFF'; // default blanco

                    switch ($modalidad) {
                        case 'presencial':
                            $color = 'C8E6C9';
                            break;
                        case 'virtual':
                            $color = 'BBDEFB';
                            break;
                        case 'Hibrida':
                        case 'hibrida':
                            $color = 'FFF9C4';
                            break;
                    }

                    if ($estado == 'finalizado') {
                        $color = 'E0E0E0';
                    }
                    if ($estado == 'suspendido') {
                        $color = 'FFE0B2';
                    }

                    $sheet->getStyle("A$row:H$row")->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB($color);
                }

                // Logo desde URL
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Instituto');
                $drawing->setPath('https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png'); // reemplaza con tu URL
                $drawing->setHeight(50);
                $drawing->setCoordinates('A1'); // columna y fila donde se insertará
                $drawing->setWorksheet($sheet);
            },
        ];
    }
}
