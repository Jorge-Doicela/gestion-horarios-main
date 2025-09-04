<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Horarios Académicos</title>
    <style>
        @page {
            margin: 20px;
            size: A4;
        }

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding: 15px 0;
            border-bottom: 3px solid #2E5BBA;
            position: relative;
        }

        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #2E5BBA;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .date {
            font-size: 11px;
            color: #888;
            font-style: italic;
        }

        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stats-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            margin: 5px;
            flex: 1;
            min-width: 150px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stats-title {
            font-size: 11px;
            font-weight: bold;
            color: #2E5BBA;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .stats-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .stats-subtitle {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            background: linear-gradient(135deg, #2E5BBA 0%, #1e4ba8 100%);
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px 6px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #1e4ba8;
        }

        td {
            padding: 8px 6px;
            text-align: left;
            font-size: 9px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .modalidad-presencial {
            background-color: #d4edda !important;
            border-left: 4px solid #28a745;
        }

        .modalidad-virtual {
            background-color: #d1ecf1 !important;
            border-left: 4px solid #17a2b8;
        }

        .modalidad-hibrida {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }

        .estado-activo {
            color: #155724;
            font-weight: bold;
        }

        .estado-suspendido {
            color: #856404;
            font-weight: bold;
        }

        .estado-finalizado {
            color: #721c24;
            font-weight: bold;
        }

        .center-text {
            text-align: center;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }

        .footer p {
            margin: 3px 0;
        }

        .page-number {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 8px;
            color: #999;
        }

        .highlight {
            background-color: #fff3cd;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-activo {
            background-color: #d4edda;
            color: #155724;
        }

        .status-suspendido {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-finalizado {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="https://institutotraversari.edu.ec/wp-content/uploads/2025/01/ISTPET-ORIGINAL.png" alt="Logo"
            class="logo">
        <div class="title">Reporte de Horarios Académicos</div>
        <div class="subtitle">Instituto Superior Tecnológico Pedro Mayor Traversari</div>
        <div class="date">Generado el: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <div class="stats-container">
        <div class="stats-box">
            <div class="stats-title">Total Horarios</div>
            <div class="stats-value">{{ $horarios->count() }}</div>
            <div class="stats-subtitle">Registros encontrados</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Activos</div>
            <div class="stats-value">{{ $horarios->where('estado', 'activo')->count() }}</div>
            <div class="stats-subtitle">En funcionamiento</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Suspendidos</div>
            <div class="stats-value">{{ $horarios->where('estado', 'suspendido')->count() }}</div>
            <div class="stats-subtitle">Temporalmente pausados</div>
        </div>

        <div class="stats-box">
            <div class="stats-title">Finalizados</div>
            <div class="stats-value">{{ $horarios->where('estado', 'finalizado')->count() }}</div>
            <div class="stats-subtitle">Completados</div>
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

    <table>
        <thead>
            <tr>
                <th>Paralelo</th>
                <th>Materia</th>
                <th>Docente</th>
                <th>Espacio</th>
                <th>Día</th>
                <th>Horario</th>
                <th>Período</th>
                <th>Modalidad</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horarios as $horario)
                <tr class="modalidad-{{ $horario->modalidad }}">
                    <td><strong>{{ $horario->paralelo->nombre }}</strong></td>
                    <td>{{ $horario->materia->nombre }}</td>
                    <td>{{ $horario->docente->nombre }}</td>
                    <td>{{ $horario->espacio ? $horario->espacio->nombre : '<em>Sin asignar</em>' }}</td>
                    <td class="center-text">{{ $horario->dia->nombre }}</td>
                    <td class="center-text">{{ $horario->hora->hora_inicio }}<br>-<br>{{ $horario->hora->hora_fin }}
                    </td>
                    <td class="center-text">{{ $horario->periodo->nombre }}</td>
                    <td class="center-text">
                        <span class="highlight">{{ ucfirst($horario->modalidad) }}</span>
                    </td>
                    <td class="center-text">
                        <span class="status-badge status-{{ $horario->estado }}">
                            {{ ucfirst($horario->estado) }}
                        </span>
                    </td>
                    <td class="center-text">{{ \Carbon\Carbon::parse($horario->fecha_inicio)->format('d/m/Y') }}</td>
                    <td class="center-text">{{ \Carbon\Carbon::parse($horario->fecha_fin)->format('d/m/Y') }}</td>
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
