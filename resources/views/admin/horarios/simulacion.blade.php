@extends('layouts.app')

@section('title', 'Simulación de Generación de Horarios')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Simulación de Generación</h1>
            <p class="text-gray-600">Período: <span class="font-semibold">{{ $periodo->nombre ?? "#{$periodo->id}" }}</span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl shadow p-5 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Horas propuestas</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $resultado['horas_propuestas'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl shadow p-5 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-2 bg-red-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Conflictos detectados</p>
                        <p class="text-2xl font-bold text-red-700">{{ count($resultado['conflictos'] ?? []) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl shadow p-5 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-2 bg-green-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Modalidades</p>
                        <p class="text-sm font-medium text-green-700">{{ implode(', ', $options['modalidades'] ?? []) }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl shadow p-5 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-500 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Materias</p>
                        <p class="text-2xl font-bold text-purple-700">
                            {{ count(collect($resultado['propuestas'] ?? [])->pluck('materia')->unique()) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <h2 class="text-xl font-semibold">Propuestas</h2>
                    <form method="POST" action="{{ route('horarios.generar') }}" class="hidden"></form>
                    <form method="GET" action="{{ route('horarios.simular') }}" class="flex items-center gap-2">
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
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Materia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Docente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Paralelo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Día
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Espacio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Modalidad</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse(($resultado['propuestas'] ?? []) as $index => $p)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $p['materia'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p['docente'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $p['paralelo'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p['dia'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                    {{ $p['hora'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p['espacio'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $modalidadColors = [
                                            'presencial' => 'bg-blue-100 text-blue-800',
                                            'virtual' => 'bg-purple-100 text-purple-800',
                                            'hibrida' => 'bg-yellow-100 text-yellow-800',
                                        ];
                                        $color = $modalidadColors[$p['modalidad']] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                        {{ ucfirst($p['modalidad']) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay propuestas</h3>
                                        <p class="text-gray-500">No se encontraron horarios propuestos con los filtros
                                            actuales.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if (!empty($resultado['conflictos']))
            <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Conflictos Detectados</h3>
                        <p class="text-sm text-red-700">Se encontraron los siguientes problemas que requieren atención:</p>
                    </div>
                </div>
                <div class="mt-2">
                    <ul class="list-disc list-inside space-y-1 text-sm text-red-700">
                        @foreach ($resultado['conflictos'] as $conflicto)
                            <li>{{ $conflicto }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

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
