<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Generación</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            margin-bottom: 12px;
        }

        .title {
            font-size: 18px;
            font-weight: 700;
        }

        .muted {
            color: #6B7280;
        }

        .grid {
            display: flex;
            gap: 8px;
            margin: 12px 0;
        }

        .card {
            flex: 1;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #E5E7EB;
            padding: 6px 8px;
        }

        thead th {
            background: #F3F4F6;
            font-size: 11px;
            text-transform: uppercase;
        }

        tbody td {
            font-size: 12px;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Simulación de Generación de Horarios</div>
        <div class="muted">Período: {{ $periodo->nombre ?? "#{$periodo->id}" }}</div>
    </div>

    <div class="grid">
        <div class="card">
            <div class="muted">Horas propuestas</div>
            <div class="title">{{ $resultado['horas_propuestas'] ?? 0 }}</div>
        </div>
        <div class="card">
            <div class="muted">Conflictos detectados</div>
            <div class="title">{{ count($resultado['conflictos'] ?? []) }}</div>
        </div>
        <div class="card">
            <div class="muted">Modalidades</div>
            <div>{{ implode(', ', $options['modalidades'] ?? []) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Materia</th>
                <th>Docente</th>
                <th>Paralelo</th>
                <th>Día</th>
                <th>Hora</th>
                <th>Espacio</th>
                <th>Modalidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse(($resultado['propuestas'] ?? []) as $p)
                <tr>
                    <td>{{ $p['materia'] }}</td>
                    <td>{{ $p['docente'] }}</td>
                    <td>{{ $p['paralelo'] }}</td>
                    <td>{{ $p['dia'] }}</td>
                    <td>{{ $p['hora'] }}</td>
                    <td>{{ $p['espacio'] }}</td>
                    <td class="right">{{ ucfirst($p['modalidad']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 10px;">No hay propuestas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
