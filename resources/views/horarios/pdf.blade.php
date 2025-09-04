<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Horario Semanal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        header img {
            width: 80px;
            height: auto;
            margin-right: 20px;
            filter: brightness(0) invert(1);
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            color: white;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #374151;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 11px;
            padding: 12px 8px;
            border: 1px solid #d1d5db;
        }

        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }

        .time-cell {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            font-weight: bold;
            font-size: 10px;
        }

        .presencial {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border: 2px solid #22c55e;
            border-radius: 8px;
            padding: 8px;
        }

        .virtual {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 8px;
        }

        .hibrida {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 8px;
            padding: 8px;
        }

        .suspendido {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 8px;
            padding: 8px;
            opacity: 0.8;
        }

        .finalizado {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 2px solid #9ca3af;
            border-radius: 8px;
            padding: 8px;
            color: #6b7280;
            opacity: 0.7;
        }

        .celda {
            padding: 8px;
        }

        .materia {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .detalle {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.3;
        }

        .conflict {
            color: #dc2626;
            font-weight: bold;
            font-size: 9px;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <header>
        <img src="https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png" alt="Logo Instituto">
        <h2>Horario Semanal - {{ $periodo_nombre ?? 'Período Académico' }}</h2>
    </header>

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
                    <td class="celda time-cell">
                        {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -<br>
                        {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                    </td>
                    @foreach ($dias as $dia)
                        @php
                            $clase = $horarios->first(fn($h) => $h->hora_id == $hora->id && $h->dia_id == $dia->id);
                            $colorClass = '';
                            if ($clase) {
                                $colorClass = strtolower($clase->modalidad);
                                if ($clase->estado == 'finalizado') {
                                    $colorClass .= ' finalizado';
                                }
                                if ($clase->estado == 'suspendido') {
                                    $colorClass .= ' suspendido';
                                }
                            }
                        @endphp
                        <td class="celda">
                            @if ($clase)
                                <div class="{{ $colorClass }}">
                                    <div class="materia">{{ $clase->materia->nombre }}</div>
                                    <div class="detalle">
                                        <strong>Paralelo:</strong> {{ $clase->paralelo->nombre }}<br>
                                        <strong>Docente:</strong> {{ $clase->docente->nombre }}<br>
                                        <strong>Espacio:</strong> {{ $clase->espacio?->nombre ?? 'Sin asignar' }}<br>
                                        <strong>Modalidad:</strong> {{ ucfirst($clase->modalidad) }}
                                        @if ($clase->conflictos->count())
                                            <div class="conflict">⚠ {{ $clase->conflictos->pluck('motivo')->join(', ') }}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div style="color: #9ca3af; font-style: italic;">-</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
