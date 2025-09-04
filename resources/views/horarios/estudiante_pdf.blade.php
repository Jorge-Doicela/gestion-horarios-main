{{-- resources/views/horarios/estudiante_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Horario Estudiante</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            font-size: 11px;
            vertical-align: top;
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

        .class-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .class-details {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.3;
        }

        .empty-cell {
            color: #9ca3af;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Horario Académico</h1>
        <p>Paralelo: {{ $paralelo->nombre }}</p>
    </div>

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
                        {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -<br>
                        {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                    </td>
                    @foreach ($dias as $dia)
                        @php
                            $clase = $horarios_matriz[$hora->id][$dia->id] ?? null;
                        @endphp
                        <td>
                            @if ($clase)
                                <div class="{{ $clase->modalidad }}">
                                    <div class="class-title">{{ $clase->materia->nombre }}</div>
                                    <div class="class-details">
                                        <strong>Docente:</strong> {{ $clase->docente->nombre }}<br>
                                        <strong>Espacio:</strong> {{ $clase->espacio?->nombre ?? 'Sin asignar' }}<br>
                                        <strong>Modalidad:</strong> {{ ucfirst($clase->modalidad) }}
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
</body>

</html>
