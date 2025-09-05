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
        $query = Horario::with(['materia', 'paralelo', 'docente', 'espacio', 'dia', 'hora', 'periodo'])
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
                'Período' => $h->periodo->nombre,
                'Modalidad' => ucfirst($h->modalidad),
                'Estado' => ucfirst($h->estado),
                'Fecha Inicio' => \Carbon\Carbon::parse($h->fecha_inicio)->format('d/m/Y'),
                'Fecha Fin' => \Carbon\Carbon::parse($h->fecha_fin)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'DÍA',
            'HORARIO',
            'MATERIA',
            'PARALELO',
            'DOCENTE',
            'ESPACIO',
            'PERÍODO',
            'MODALIDAD',
            'ESTADO',
            'FECHA INICIO',
            'FECHA FIN'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center'
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2E5BBA']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Agregar título del reporte
                $sheet->insertNewRowBefore(1, 3);
                $sheet->mergeCells('A1:K1');
                $sheet->setCellValue('A1', 'HORARIO ACADÉMICO COMPLETO - PERÍODO ACADÉMICO');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                        'color' => ['rgb' => '2c3e50']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // Agregar información del instituto
                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', 'Instituto Superior Tecnológico Pedro Mayor Traversari');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'size' => 14,
                        'color' => ['rgb' => '7f8c8d']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // Agregar fecha de generación
                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue('A3', 'Generado el: ' . now()->format('d/m/Y H:i:s'));
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'color' => ['rgb' => '95a5a6']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // Agregar línea separadora
                $sheet->mergeCells('A4:K4');
                $sheet->getStyle('A4')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0E0E0']
                    ]
                ]);
                $sheet->getRowDimension('4')->setRowHeight(2);

                // Mover encabezados a la fila 5
                $sheet->getStyle('A5:K5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '34495e']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'bdc3c7']
                        ]
                    ]
                ]);

                // Aplicar bordes y estilos a todas las filas de datos
                $rows = $sheet->getHighestRow();
                for ($row = 6; $row <= $rows; $row++) {
                    $modalidad = strtolower($sheet->getCell("H$row")->getValue());
                    $estado = strtolower($sheet->getCell("I$row")->getValue());

                    $color = 'FFFFFF'; // default blanco

                    switch ($modalidad) {
                        case 'presencial':
                            $color = 'E8F5E8';
                            break;
                        case 'virtual':
                            $color = 'E3F2FD';
                            break;
                        case 'hibrida':
                            $color = 'FFF8E1';
                            break;
                    }

                    if ($estado == 'finalizado') {
                        $color = 'F5F5F5';
                    }
                    if ($estado == 'suspendido') {
                        $color = 'FFF3E0';
                    }

                    $sheet->getStyle("A$row:K$row")->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => $color]
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => 'e9ecef']
                            ]
                        ],
                        'alignment' => [
                            'vertical' => 'center'
                        ]
                    ]);

                    // Centrar columnas específicas
                    $sheet->getStyle("A$row:B$row")->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("H$row:I$row")->getAlignment()->setHorizontal('center');
                    $sheet->getStyle("J$row:K$row")->getAlignment()->setHorizontal('center');
                }

                // Autoajustar columnas
                foreach (range('A', 'K') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // Agregar logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo Instituto');
                $drawing->setPath('https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png');
                $drawing->setHeight(60);
                $drawing->setCoordinates('A1');
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawing->setWorksheet($sheet);

                // Agregar pie de página
                $sheet->mergeCells("A" . ($rows + 2) . ":K" . ($rows + 2));
                $sheet->setCellValue("A" . ($rows + 2), 'Sistema de Gestión de Horarios Académicos');
                $sheet->getStyle("A" . ($rows + 2))->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'color' => ['rgb' => '6c757d'],
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                $sheet->mergeCells("A" . ($rows + 3) . ":K" . ($rows + 3));
                $sheet->setCellValue("A" . ($rows + 3), 'Instituto Superior Tecnológico Pedro Mayor Traversari - ' . now()->year);
                $sheet->getStyle("A" . ($rows + 3))->applyFromArray([
                    'font' => [
                        'size' => 10,
                        'color' => ['rgb' => '6c757d']
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);
            },
        ];
    }
}
