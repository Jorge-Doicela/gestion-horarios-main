<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Horarios Académicos</title>
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
            line-height: 1.5;
            color: #2c3e50;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid #34495e;
        }

        .logo {
            width: 60px;
            height: auto;
            margin-bottom: 15px;
        }

        .title {
            font-size: 24px;
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
            margin-bottom: 25px;
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
            font-size: 18px;
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
            margin-top: 20px;
            background: white;
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
            text-align: left;
            font-size: 10px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e3f2fd;
        }

        .modalidad-presencial {
            background-color: #e8f5e8 !important;
            border-left: 3px solid #27ae60;
        }

        .modalidad-virtual {
            background-color: #e3f2fd !important;
            border-left: 3px solid #3498db;
        }

        .modalidad-hibrida {
            background-color: #fff8e1 !important;
            border-left: 3px solid #f39c12;
        }

        .center-text {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
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

        .highlight {
            background-color: #ecf0f1;
            padding: 3px 6px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 9px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-activo {
            background-color: #d5f4e6;
            color: #27ae60;
        }

        .status-suspendido {
            background-color: #fef5e7;
            color: #f39c12;
        }

        .status-finalizado {
            background-color: #fadbd8;
            color: #e74c3c;
        }

        .modalidad-badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .modalidad-presencial-badge {
            background-color: #d5f4e6;
            color: #27ae60;
        }

        .modalidad-virtual-badge {
            background-color: #e3f2fd;
            color: #3498db;
        }

        .modalidad-hibrida-badge {
            background-color: #fff8e1;
            color: #f39c12;
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
                        <span class="modalidad-badge modalidad-{{ $horario->modalidad }}-badge">
                            {{ ucfirst($horario->modalidad) }}
                        </span>
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
        <p><strong>Sistema de Gestión de Horarios Académicos</strong></p>
        <p>Instituto Superior Tecnológico Pedro Mayor Traversari - {{ now()->year }}</p>
    </div>

    <div class="page-number">
        Página 1
    </div>
</body>

</html>
