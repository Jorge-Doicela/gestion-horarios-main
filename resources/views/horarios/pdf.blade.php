<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Horario Académico Completo</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 landscape;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            background: white;
            line-height: 1.5;
            color: #2c3e50;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px 0;
            border-bottom: 2px solid #34495e;
        }

        .logo {
            width: 60px;
            height: auto;
            margin-bottom: 15px;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
            font-weight: 400;
        }

        .date {
            font-size: 10px;
            color: #95a5a6;
            font-weight: 300;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }

        .stats-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            flex: 1;
            text-align: center;
            min-width: 120px;
        }

        .stats-title {
            font-size: 10px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-value {
            font-size: 16px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .stats-subtitle {
            font-size: 9px;
            color: #6c757d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th {
            background: #34495e;
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 12px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        td {
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .time-cell {
            background: #ecf0f1;
            color: #2c3e50;
            font-weight: 600;
            font-size: 10px;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #bdc3c7;
        }

        .presencial {
            background-color: #e8f5e8;
            border: 2px solid #27ae60;
            border-radius: 6px;
            padding: 8px;
            margin: 2px;
        }

        .virtual {
            background-color: #e3f2fd;
            border: 2px solid #3498db;
            border-radius: 6px;
            padding: 8px;
            margin: 2px;
        }

        .hibrida {
            background-color: #fff8e1;
            border: 2px solid #f39c12;
            border-radius: 6px;
            padding: 8px;
            margin: 2px;
        }

        .suspendido {
            background-color: #fff3e0;
            border: 2px solid #f39c12;
            border-radius: 6px;
            padding: 8px;
            margin: 2px;
            opacity: 0.8;
        }

        .finalizado {
            background-color: #f5f5f5;
            border: 2px solid #95a5a6;
            border-radius: 6px;
            padding: 8px;
            margin: 2px;
            color: #7f8c8d;
            opacity: 0.7;
        }

        .materia {
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 4px;
            color: #2c3e50;
            line-height: 1.2;
        }

        .detalle {
            font-size: 9px;
            color: #7f8c8d;
            line-height: 1.3;
        }

        .detalle strong {
            color: #34495e;
        }

        .conflict {
            color: #e74c3c;
            font-weight: 600;
            font-size: 8px;
            margin-top: 4px;
            background: #fadbd8;
            padding: 3px 6px;
            border-radius: 4px;
        }

        .empty-cell {
            color: #bdc3c7;
            font-style: italic;
            font-size: 10px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }

        .footer p {
            margin: 2px 0;
        }

        .page-number {
            position: fixed;
            bottom: 15mm;
            right: 15mm;
            font-size: 9px;
            color: #95a5a6;
        }

        .legend {
            margin-bottom: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .legend-title {
            font-size: 10px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .legend-items {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            font-size: 9px;
            color: #6c757d;
        }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 4px;
            margin-right: 6px;
            border: 1px solid #bdc3c7;
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
            <div class="stats-title">Total</div>
            <div class="stats-value">{{ $horarios->count() }}</div>
            <div class="stats-subtitle">Horarios</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Activos</div>
            <div class="stats-value">{{ $horarios->where('estado', 'activo')->count() }}</div>
            <div class="stats-subtitle">En curso</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Presencial</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'presencial')->count() }}</div>
            <div class="stats-subtitle">Modalidad</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Virtual</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'virtual')->count() }}</div>
            <div class="stats-subtitle">Modalidad</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Híbrida</div>
            <div class="stats-value">{{ $horarios->where('modalidad', 'hibrida')->count() }}</div>
            <div class="stats-subtitle">Modalidad</div>
        </div>
    </div>

    <div class="legend">
        <div class="legend-title">Leyenda de Modalidades</div>
        <div class="legend-items">
            <div class="legend-item">
                <div class="legend-color" style="background-color: #e8f5e8; border-color: #27ae60;"></div>
                Presencial
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #e3f2fd; border-color: #3498db;"></div>
                Virtual
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #fff8e1; border-color: #f39c12;"></div>
                Híbrida
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #f5f5f5; border-color: #95a5a6;"></div>
                Finalizado
            </div>
            <div class="legend-item">
                <div class="legend-color" style="background-color: #fff3e0; border-color: #f39c12;"></div>
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
        <p><strong>Sistema de Gestión de Horarios Académicos</strong></p>
        <p>Instituto Superior Tecnológico Pedro Mayor Traversari - {{ now()->year }}</p>
    </div>

    <div class="page-number">
        Página 1
    </div>
</body>

</html>
