{{-- resources/views/horarios/estudiante_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Horario Estudiante</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: white;
            font-size: 11px;
            line-height: 1.5;
            color: #2c3e50;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid #34495e;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 0;
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 400;
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 10px;
            padding: 12px 8px;
            border: none;
        }

        td {
            border-bottom: 1px solid #e9ecef;
            padding: 10px 8px;
            text-align: center;
            font-size: 10px;
            vertical-align: top;
        }

        .time-cell {
            background: #ecf0f1;
            color: #2c3e50;
            font-weight: 600;
            font-size: 10px;
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

        .class-title {
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 4px;
            color: #2c3e50;
        }

        .class-details {
            font-size: 9px;
            color: #7f8c8d;
            line-height: 1.3;
        }

        .empty-cell {
            color: #bdc3c7;
            font-style: italic;
            font-size: 10px;
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
