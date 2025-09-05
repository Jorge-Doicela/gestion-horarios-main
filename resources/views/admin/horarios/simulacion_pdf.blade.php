<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulación de Generación</title>
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
            font-size: 11px;
            color: #2c3e50;
            background: white;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px 0;
            border-bottom: 2px solid #34495e;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .muted {
            color: #7f8c8d;
            font-size: 14px;
            font-weight: 400;
        }

        .grid {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .card {
            flex: 1;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 15px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th,
        td {
            border-bottom: 1px solid #e9ecef;
            padding: 10px 8px;
            text-align: left;
        }

        thead th {
            background: #34495e;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: none;
        }

        tbody td {
            font-size: 10px;
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
