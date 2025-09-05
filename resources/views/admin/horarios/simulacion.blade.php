@extends('layouts.app')

@section('title', 'Simulación de Generación de Horarios')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Simulación de Generación</h1>
            <p class="text-gray-600">Período: <span class="font-semibold">{{ $periodo->nombre ?? "#{$periodo->id}" }}</span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Horas propuestas</p>
                <p class="text-2xl font-bold">{{ $resultado['horas_propuestas'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Conflictos detectados</p>
                <p class="text-2xl font-bold">{{ count($resultado['conflictos'] ?? []) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Modalidades</p>
                <p class="text-md font-medium">{{ implode(', ', $options['modalidades'] ?? []) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <h2 class="text-xl font-semibold">Propuestas</h2>
                    <form method="POST" action="{{ route('horarios.generar') }}" class="hidden"></form>
                    <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2">
                        <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                        @foreach ($options['modalidades'] ?? [] as $m)
                            <input type="hidden" name="modalidades[]" value="{{ $m }}">
                        @endforeach
                        @foreach ($options['paralelos'] ?? [] as $par)
                            <input type="hidden" name="paralelos[]" value="{{ $par }}">
                        @endforeach
                        @foreach ($options['docentes'] ?? [] as $d)
                            <input type="hidden" name="docentes[]" value="{{ $d }}">
                        @endforeach
                        @foreach ($options['dias'] ?? [] as $di)
                            <input type="hidden" name="dias[]" value="{{ $di }}">
                        @endforeach
                        <input type="hidden" name="hora_desde" value="{{ $options['hora_desde'] ?? '' }}">
                        <input type="hidden" name="hora_hasta" value="{{ $options['hora_hasta'] ?? '' }}">
                        <input type="hidden" name="validar_conflictos"
                            value="{{ $options['validar_conflictos'] ?? true }}">
                        <input type="hidden" name="respetar_restricciones"
                            value="{{ $options['respetar_restricciones'] ?? true }}">
                        <input type="hidden" name="balancear_carga" value="{{ $options['balancear_carga'] ?? true }}">
                        <input type="hidden" name="priorizar_materias"
                            value="{{ $options['priorizar_materias'] ?? true }}">
                        <input type="hidden" name="simular" value="1">

                        <select name="f_docente" class="border rounded-lg px-2 py-1 text-sm">
                            <option value="">Docente (todos)</option>
                            @php
                                $ids = collect($resultado['propuestas'] ?? [])
                                    ->pluck('docente_id', 'docente')
                                    ->unique();
                            @endphp
                            @foreach ($ids as $docenteNombre => $docenteId)
                                <option value="{{ $docenteId }}"
                                    {{ request('f_docente') == $docenteId ? 'selected' : '' }}>{{ $docenteNombre }}
                                </option>
                            @endforeach
                        </select>
                        <select name="f_paralelo" class="border rounded-lg px-2 py-1 text-sm">
                            <option value="">Paralelo (todos)</option>
                            @php
                                $pars = collect($resultado['propuestas'] ?? [])
                                    ->pluck('paralelo_id', 'paralelo')
                                    ->unique();
                            @endphp
                            @foreach ($pars as $paraleloNombre => $paraleloId)
                                <option value="{{ $paraleloId }}"
                                    {{ request('f_paralelo') == $paraleloId ? 'selected' : '' }}>{{ $paraleloNombre }}
                                </option>
                            @endforeach
                        </select>
                        <button class="px-3 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm">Filtrar</button>
                    </form>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Materia</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Docente</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paralelo</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Día</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Hora</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Espacio</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Modalidad</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse(($resultado['propuestas'] ?? []) as $p)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-800">{{ $p['materia'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $p['docente'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $p['paralelo'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $p['dia'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $p['hora'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $p['espacio'] }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($p['modalidad']) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay propuestas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}" class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-50">
                    Volver
                </a>
                <form method="GET" action="{{ route('admin.horarios.simulacion.pdf') }}">
                    <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                    @foreach ($options['modalidades'] ?? [] as $m)
                        <input type="hidden" name="modalidades[]" value="{{ $m }}">
                    @endforeach
                    @foreach ($options['paralelos'] ?? [] as $par)
                        <input type="hidden" name="paralelos[]" value="{{ $par }}">
                    @endforeach
                    @foreach ($options['docentes'] ?? [] as $d)
                        <input type="hidden" name="docentes[]" value="{{ $d }}">
                    @endforeach
                    @foreach ($options['dias'] ?? [] as $di)
                        <input type="hidden" name="dias[]" value="{{ $di }}">
                    @endforeach
                    <input type="hidden" name="hora_desde" value="{{ $options['hora_desde'] ?? '' }}">
                    <input type="hidden" name="hora_hasta" value="{{ $options['hora_hasta'] ?? '' }}">
                    <input type="hidden" name="validar_conflictos"
                        value="{{ $options['validar_conflictos'] ?? true }}">
                    <input type="hidden" name="respetar_restricciones"
                        value="{{ $options['respetar_restricciones'] ?? true }}">
                    <input type="hidden" name="balancear_carga" value="{{ $options['balancear_carga'] ?? true }}">
                    <input type="hidden" name="priorizar_materias"
                        value="{{ $options['priorizar_materias'] ?? true }}">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-rose-600 text-white hover:bg-rose-700 shadow">
                        Exportar PDF
                    </button>
                </form>
                <form method="GET" action="{{ route('admin.horarios.simulacion.excel') }}">
                    <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                    @foreach ($options['modalidades'] ?? [] as $m)
                        <input type="hidden" name="modalidades[]" value="{{ $m }}">
                    @endforeach
                    @foreach ($options['paralelos'] ?? [] as $par)
                        <input type="hidden" name="paralelos[]" value="{{ $par }}">
                    @endforeach
                    @foreach ($options['docentes'] ?? [] as $d)
                        <input type="hidden" name="docentes[]" value="{{ $d }}">
                    @endforeach
                    @foreach ($options['dias'] ?? [] as $di)
                        <input type="hidden" name="dias[]" value="{{ $di }}">
                    @endforeach
                    <input type="hidden" name="hora_desde" value="{{ $options['hora_desde'] ?? '' }}">
                    <input type="hidden" name="hora_hasta" value="{{ $options['hora_hasta'] ?? '' }}">
                    <input type="hidden" name="validar_conflictos"
                        value="{{ $options['validar_conflictos'] ?? true }}">
                    <input type="hidden" name="respetar_restricciones"
                        value="{{ $options['respetar_restricciones'] ?? true }}">
                    <input type="hidden" name="balancear_carga" value="{{ $options['balancear_carga'] ?? true }}">
                    <input type="hidden" name="priorizar_materias"
                        value="{{ $options['priorizar_materias'] ?? true }}">
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 shadow">
                        Exportar Excel
                    </button>
                </form>
            </div>
            <form method="POST" action="{{ route('horarios.generar') }}">
                @csrf
                <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">
                @foreach ($options['modalidades'] ?? [] as $m)
                    <input type="hidden" name="modalidades[]" value="{{ $m }}">
                @endforeach
                @foreach ($options['paralelos'] ?? [] as $par)
                    <input type="hidden" name="paralelos[]" value="{{ $par }}">
                @endforeach
                @foreach ($options['docentes'] ?? [] as $d)
                    <input type="hidden" name="docentes[]" value="{{ $d }}">
                @endforeach
                @foreach ($options['dias'] ?? [] as $di)
                    <input type="hidden" name="dias[]" value="{{ $di }}">
                @endforeach
                <input type="hidden" name="hora_desde" value="{{ $options['hora_desde'] ?? '' }}">
                <input type="hidden" name="hora_hasta" value="{{ $options['hora_hasta'] ?? '' }}">
                <input type="hidden" name="validar_conflictos" value="{{ $options['validar_conflictos'] ?? true }}">
                <input type="hidden" name="respetar_restricciones"
                    value="{{ $options['respetar_restricciones'] ?? true }}">
                <input type="hidden" name="balancear_carga" value="{{ $options['balancear_carga'] ?? true }}">
                <input type="hidden" name="priorizar_materias" value="{{ $options['priorizar_materias'] ?? true }}">

                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow">
                    Confirmar y Guardar
                </button>
            </form>
        </div>
    </div>
@endsection
