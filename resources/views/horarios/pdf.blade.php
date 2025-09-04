<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Horario Académico Completo</title>
    <style>
        @page {
            margin: 15px;
            size: A4 landscape;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px 0;
            background: linear-gradient(135deg, #2E5BBA 0%, #1e4ba8 100%);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .logo {
            width: 70px;
            height: auto;
            margin-bottom: 8px;
            filter: brightness(0) invert(1);
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 12px;
            color: #e0e7ff;
            margin-bottom: 5px;
        }

        .date {
            font-size: 10px;
            color: #c7d2fe;
            font-style: italic;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .stats-box {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px;
            flex: 1;
            min-width: 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stats-title {
            font-size: 9px;
            font-weight: bold;
            color: #2E5BBA;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .stats-value {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
        }

        .stats-subtitle {
            font-size: 8px;
            color: #6b7280;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1f2937;
            font-weight: bold;
            text-align: center;
            padding: 10px 6px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #d1d5db;
        }

        td {
            padding: 6px;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            border: 1px solid #e5e7eb;
        }

        .time-cell {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1f2937;
            font-weight: bold;
            font-size: 9px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #d1d5db;
        }

        .presencial {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border: 2px solid #22c55e;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
        }

        .virtual {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
        }

        .hibrida {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
        }

        .suspendido {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
            opacity: 0.8;
        }

        .finalizado {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 2px solid #9ca3af;
            border-radius: 6px;
            padding: 6px;
            margin: 2px;
            color: #6b7280;
            opacity: 0.7;
        }

        .materia {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 3px;
            color: #1f2937;
            line-height: 1.2;
        }

        .detalle {
            font-size: 8px;
            color: #4b5563;
            line-height: 1.2;
        }

        .detalle strong {
            color: #374151;
        }

        .conflict {
            color: #dc2626;
            font-weight: bold;
            font-size: 8px;
            margin-top: 3px;
            background: rgba(220, 38, 38, 0.1);
            padding: 2px 4px;
            border-radius: 3px;
        }

        .empty-cell {
            color: #9ca3af;
            font-style: italic;
            font-size: 9px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .footer p {
            margin: 2px 0;
        }

        .page-number {
            position: fixed;
            bottom: 10px;
            right: 15px;
            font-size: 8px;
            color: #9ca3af;
        }

        .legend {
            margin-bottom: 10px;
            padding: 8px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        .legend-title {
            font-size: 9px;
            font-weight: bold;
            color: #2E5BBA;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .legend-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 8px;
            color: #4b5563;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            margin-right: 5px;
            border: 1px solid #d1d5db;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png" alt="Logo"
            class="logo">
        <div class="title">Horario Académico Completo</div>
        <div class="subtitle">Instituto Superior Tecnológico Pedro Mayor Traversari</div>
        <div class="date">Generado el: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="stats-container">
        <div class="stats-box">
            <div class="stats-title">Total Horarios</div>
            <div class="stats-value">{{ $horarios->count() }}</div>
            <div class="stats-subtitle">Registros totales</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Activos</div>
            <div class="stats-value">{{ $horarios->where('estado', 'activo')->count() }}</div>
            <div class="stats-subtitle">En funcionamiento</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Presencial</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'presencial')->count() }}</div>
            <div class="stats-subtitle">Modalidad tradicional</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Virtual</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'virtual')->count() }}</div>
            <div class="stats-subtitle">En línea</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Híbrida</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'hibrida')->count() }}</div>
            <div class="stats-subtitle">Combinada</div>
        </div>
    </div>

    <div class="legend">
        <div class="legend-title">Leyenda de Modalidades</div>
        <div class="legend-items">
            <div class="legend-item">
                <div class="legend-color"
                    style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); border-color: #22c55e;"></div>
                Presencial
            </div>
            <div class="legend-item">
                <div class="legend-color"
                    style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-color: #3b82f6;"></div>
                Virtual
            </div>
            <div class="legend-item">
                <div class="legend-color"
                    style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-color: #f59e0b;"></div>
                Híbrida
            </div>
            <div class="legend-item">
                <div class="legend-color"
                    style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); border-color: #9ca3af;"></div>
                Finalizado
            </div>
            <div class="legend-item">
                <div class="legend-color"
                    style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border-color: #f59e0b; opacity: 0.8;">
                </div>
                Suspendido
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table>
        <thead>
            <tr>
                <th>Hora / Día</th>
                @foreach ($dias as $dia)
                    <th>{{ $dia->nombre }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($horas as $hora)
                <tr>
                    <td class="time-cell">
                        {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }}<br>
                        -<br>
                        {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                    </td>
                    @foreach ($dias as $dia)
                        @php
                            $clase = $horarios->first(fn($h) => $h->hora_id == $hora->id && $h->dia_id == $dia->id);
                            $colorClass = '';
                            if ($clase) {
                                $colorClass = strtolower($clase->modalidad);
                                if ($clase->estado == 'finalizado') {
                                    $colorClass = 'finalizado';
                                }
                                if ($clase->estado == 'suspendido') {
                                    $colorClass = 'suspendido';
                                }
                            }
                        @endphp
                        <td>
                            @if ($clase)
                                <div class="{{ $colorClass }}">
                                    <div class="materia">{{ $clase->materia->nombre }}</div>
                                    <div class="detalle">
                                        <strong>Paralelo:</strong> {{ $clase->paralelo->nombre }}<br>
                                        <strong>Docente:</strong> {{ $clase->docente->nombre }}<br>
                                        <strong>Espacio:</strong> {{ $clase->espacio?->nombre ?? 'Sin asignar' }}<br>
                                        <strong>Modalidad:</strong> {{ ucfirst($clase->modalidad) }}
                                        @if ($clase->conflictos->count())
                                            <div class="conflict">⚠
                                                {{ $clase->conflictos->pluck('motivo')->join(', ') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="empty-cell">-</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Este reporte fue generado automáticamente por el sistema de gestión de horarios académicos.</strong>
        </p>
        <p>Instituto Superior Tecnológico Pedro Mayor Traversari - {{ now()->year }}</p>
        <p>Para consultas o soporte técnico, contacte al departamento de sistemas.</p>
    </div>

    <div class="page-number">
        Página 1
    </div>
</body>

</html>
