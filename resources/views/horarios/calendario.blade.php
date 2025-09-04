{{-- resources/views/horarios/calendario.blade.php --}}
@extends('layouts.app')

@section('title', 'Horario Semanal - Docente')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Horario Semanal - Docente</h1>
                <p class="text-gray-600">Visualice y administre el horario académico del período seleccionado</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            @if (isset($error))
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $error }}
                    </div>
                </div>
            @endif

            <!-- Filter and Export Controls -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-6 animate-fade-in-up"
                style="animation-delay: 0.2s;">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <!-- Period Filter -->
                    <form method="GET" action="{{ route('horarios.calendario') }}" class="flex items-center gap-4">
                        <label for="periodo_id" class="text-sm font-semibold text-gray-700 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Seleccionar Período:
                        </label>
                        <select name="periodo_id" id="periodo_id"
                            class="px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}" @if ($periodo->id == $periodo_id) selected @endif>
                                    {{ $periodo->nombre }} ({{ $periodo->fecha_inicio }} - {{ $periodo->fecha_fin }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                    </path>
                                </svg>
                                Filtrar
                            </span>
                        </button>
                    </form>

                    <!-- Export Buttons -->
                    <div class="flex gap-3">
                        <a href="{{ route('horarios.export.pdf', ['periodo_id' => $periodo_id]) }}"
                            class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Descargar PDF
                            </span>
                        </a>
                        <a href="{{ route('horarios.export.excel', ['periodo_id' => $periodo_id]) }}"
                            class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-2 rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Descargar Excel
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            @php
                $dias = \App\Models\Dia::orderBy('id')->get();
                $horas = \App\Models\Hora::orderBy('hora_inicio')->get();
            @endphp

            <!-- Schedule Table -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden animate-fade-in-up"
                style="animation-delay: 0.3s;">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Hora / Día
                                    </div>
                                </th>
                                @foreach ($dias as $dia)
                                    <th
                                        class="px-4 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $dia->nombre }}
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($horas as $hora)
                                <tr class="hover:bg-gray-50/50 transition-all duration-200">
                                    <td class="px-6 py-4 text-center font-semibold text-sm text-gray-900 bg-gray-50/50">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-1">
                                                <span
                                                    class="text-white font-bold text-xs">{{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }}</span>
                                            </div>
                                            <div class="text-xs text-gray-600">
                                                {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                                            </div>
                                        </div>
                                    </td>
                                    @foreach ($dias as $dia)
                                        @php
                                            $clase = $horarios->first(
                                                fn($h) => $h->hora_id == $hora->id && $h->dia_id == $dia->id,
                                            );
                                        @endphp
                                        <td class="px-4 py-4 text-center align-top">
                                            @if ($clase)
                                                @php
                                                    $bgClass = match ($clase->modalidad) {
                                                        'presencial'
                                                            => 'bg-gradient-to-br from-green-100 to-green-200 border-green-300',
                                                        'virtual'
                                                            => 'bg-gradient-to-br from-blue-100 to-blue-200 border-blue-300',
                                                        'hibrida'
                                                            => 'bg-gradient-to-br from-yellow-100 to-yellow-200 border-yellow-300',
                                                        default
                                                            => 'bg-gradient-to-br from-gray-100 to-gray-200 border-gray-300',
                                                    };
                                                    $statusClass = match ($clase->estado) {
                                                        'activo' => 'ring-2 ring-green-400',
                                                        'suspendido' => 'ring-2 ring-yellow-400',
                                                        'finalizado' => 'ring-2 ring-red-400 opacity-75',
                                                        default => '',
                                                    };
                                                @endphp
                                                <div
                                                    class="rounded-xl p-3 border-2 {{ $bgClass }} {{ $statusClass }} shadow-sm hover:shadow-md transition-all duration-200">
                                                    <div class="text-sm font-bold text-gray-900 mb-2">
                                                        {{ $clase->materia->nombre }}</div>
                                                    <div class="space-y-1 text-xs text-gray-700">
                                                        <div class="flex items-center justify-center">
                                                            <svg class="w-3 h-3 mr-1 text-indigo-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                                </path>
                                                            </svg>
                                                            {{ $clase->paralelo->nombre }}
                                                        </div>
                                                        <div class="flex items-center justify-center">
                                                            <svg class="w-3 h-3 mr-1 text-indigo-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                                </path>
                                                            </svg>
                                                            {{ $clase->docente->nombre }}
                                                        </div>
                                                        <div class="flex items-center justify-center">
                                                            <svg class="w-3 h-3 mr-1 text-indigo-600" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                                </path>
                                                            </svg>
                                                            {{ $clase->espacio?->nombre ?? 'Sin asignar' }}
                                                        </div>
                                                        <div class="flex items-center justify-center">
                                                            <span
                                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                                {{ $clase->modalidad == 'presencial'
                                                                    ? 'bg-green-100 text-green-800'
                                                                    : ($clase->modalidad == 'virtual'
                                                                        ? 'bg-blue-100 text-blue-800'
                                                                        : 'bg-yellow-100 text-yellow-800') }}">
                                                                {{ ucfirst($clase->modalidad) }}
                                                            </span>
                                                        </div>
                                                        @if ($clase->conflictos->count())
                                                            <div
                                                                class="mt-2 p-2 bg-red-100 border border-red-300 rounded-lg">
                                                                <div
                                                                    class="flex items-center justify-center text-red-700 font-bold text-xs">
                                                                    <svg class="w-3 h-3 mr-1" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                                        </path>
                                                                    </svg>
                                                                    {{ $clase->conflictos->pluck('motivo')->join(', ') }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="w-full h-16 flex items-center justify-center">
                                                    <span class="text-gray-400 text-sm">-</span>
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
