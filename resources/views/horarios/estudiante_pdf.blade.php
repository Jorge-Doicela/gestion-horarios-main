{{-- resources/views/horarios/estudiante_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Horario Estudiante</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
        }

        .presencial {
            background-color: #c6f6d5;
        }

        .virtual {
            background-color: #bee3f8;
        }

        .hibrida {
            background-color: #faf089;
        }
    </style>
</head>

<body>
    <h2>Horario - {{ $paralelo->nombre }}</h2>

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
                    <td>{{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}</td>
                    @foreach ($dias as $dia)
                        @php
                            $clase = $horarios_matriz[$hora->id][$dia->id] ?? null;
                        @endphp
                        <td class="{{ $clase ? $clase->modalidad : '' }}">
                            @if ($clase)
                                {{ $clase->materia->nombre }}<br>
                                {{ $clase->docente->nombre }}<br>
                                {{ $clase->espacio?->nombre ?? 'Sin asignar' }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
