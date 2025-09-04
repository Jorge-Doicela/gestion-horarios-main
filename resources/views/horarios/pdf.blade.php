<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Horario Semanal</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
        }

        header img {
            width: 80px;
            height: auto;
            margin-right: 15px;
        }

        header h2 {
            margin: 0;
            font-size: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }

        th {
            background-color: #f0f0f0;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .presencial {
            background-color: #c8e6c9;
        }

        .virtual {
            background-color: #bbdefb;
        }

        .hibrida {
            background-color: #fff9c4;
        }

        .suspendido {
            background-color: #ffe0b2;
        }

        .finalizado {
            background-color: #e0e0e0;
            color: #555;
        }

        .celda {
            padding: 5px;
        }

        .materia {
            font-weight: bold;
            font-size: 12px;
        }

        .detalle {
            font-size: 10px;
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
                    <td class="celda">{{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}</td>
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
                        <td class="celda {{ $colorClass }}">
                            @if ($clase)
                                <div class="materia">{{ $clase->materia->nombre }}</div>
                                <div class="detalle">
                                    Paralelo: {{ $clase->paralelo->nombre }}<br>
                                    Docente: {{ $clase->docente->nombre }}<br>
                                    Espacio: {{ $clase->espacio?->nombre ?? 'Sin asignar' }}<br>
                                    Modalidad: {{ ucfirst($clase->modalidad) }}
                                    @if ($clase->conflictos->count())
                                        <br><span style="color:red;">⚠
                                            {{ $clase->conflictos->pluck('motivo')->join(', ') }}</span>
                                    @endif
                                </div>
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
