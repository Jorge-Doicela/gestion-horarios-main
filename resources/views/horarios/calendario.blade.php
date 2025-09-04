{{-- resources/views/horarios/calendario.blade.php --}}
@extends('layouts.app')

@section('title', 'Horario Semanal - Docente')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Horario Semanal - Docente</h1>

        {{-- Mensajes de éxito o error --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        @if (isset($error))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        {{-- Filtro de período académico --}}
        <form method="GET" action="{{ route('horarios.calendario') }}" class="mb-2 flex items-center gap-4">
            <label for="periodo_id" class="font-semibold">Seleccionar Período:</label>
            <select name="periodo_id" id="periodo_id" class="border rounded px-2 py-1">
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id }}" @if ($periodo->id == $periodo_id) selected @endif>
                        {{ $periodo->nombre }} ({{ $periodo->fecha_inicio }} - {{ $periodo->fecha_fin }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700">Filtrar</button>
        </form>

        {{-- Botones de descarga --}}
        <div class="flex gap-2 mb-4">
            <a href="{{ route('horarios.export.pdf', ['periodo_id' => $periodo_id]) }}"
                class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 text-sm">
                Descargar PDF
            </a>
            <a href="{{ route('horarios.export.excel', ['periodo_id' => $periodo_id]) }}"
                class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 text-sm">
                Descargar Excel
            </a>
        </div>

        @php
            $dias = \App\Models\Dia::orderBy('id')->get();
            $horas = \App\Models\Hora::orderBy('hora_inicio')->get();
        @endphp

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Hora / Día</th>
                        @foreach ($dias as $dia)
                            <th class="border p-2">{{ $dia->nombre }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horas as $hora)
                        <tr class="hover:bg-gray-50">
                            <td class="border p-2 font-semibold text-sm">
                                {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                            </td>
                            @foreach ($dias as $dia)
                                @php
                                    $clase = $horarios->first(
                                        fn($h) => $h->hora_id == $hora->id && $h->dia_id == $dia->id,
                                    );
                                @endphp
                                <td class="border p-2 text-xs align-top">
                                    @if ($clase)
                                        @php
                                            switch ($clase->modalidad) {
                                                case 'presencial':
                                                    $bg = 'bg-green-200';
                                                    break;
                                                case 'virtual':
                                                    $bg = 'bg-blue-200';
                                                    break;
                                                case 'hibrida':
                                                    $bg = 'bg-yellow-200';
                                                    break;
                                                default:
                                                    $bg = 'bg-gray-200';
                                            }
                                        @endphp
                                        <div class="rounded p-1 {{ $bg }}">
                                            <strong>{{ $clase->materia->nombre }}</strong><br>
                                            Paralelo: {{ $clase->paralelo->nombre }}<br>
                                            Espacio: {{ $clase->espacio?->nombre ?? 'Sin asignar' }}<br>
                                            Modalidad: {{ ucfirst($clase->modalidad) }}
                                            @if ($clase->conflictos->count())
                                                <div class="text-red-600 font-bold text-xs mt-1">
                                                    ⚠ {{ $clase->conflictos->pluck('motivo')->join(', ') }}
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
