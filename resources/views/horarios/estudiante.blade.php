{{-- resources/views/horarios/estudiante.blade.php --}}
@extends('layouts.app')

@section('title', 'Horario Semanal - Estudiante')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Horario Semanal - Estudiante</h1>
                <p class="text-gray-600">Visualice su horario académico personalizado</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if ($error)
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $error }}
                    </div>
                </div>
            @else
                <!-- Export Controls -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                        <a href="{{ route('horario.estudiante.pdf') }}" target="_blank"
                           class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar PDF
                            </span>
                        </a>
                        <a href="{{ route('horario.estudiante.excel') }}"
                           class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exportar Excel
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Schedule Table -->
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Hora / Día
                                        </div>
                                    </th>
                                    @foreach ($dias as $dia)
                                        <th class="px-4 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mb-1">
                                                    <span class="text-white font-bold text-xs">{{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }}</span>
                                                </div>
                                                <div class="text-xs text-gray-600">
                                                    {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>

                                        @foreach ($dias as $dia)
                                            @php
                                                $clase = $horarios->first(function ($h) use ($hora, $dia) {
                                                    return $h->hora_id == $hora->id && $h->dia_id == $dia->id;
                                                });
                                            @endphp

                                            <td class="px-4 py-4 text-center align-top">
                                                @if ($clase)
                                                    @php
                                                        $bgClass = match ($clase->modalidad) {
                                                            'presencial' => 'bg-gradient-to-br from-green-100 to-green-200 border-green-300',
                                                            'virtual' => 'bg-gradient-to-br from-blue-100 to-blue-200 border-blue-300',
                                                            'hibrida' => 'bg-gradient-to-br from-yellow-100 to-yellow-200 border-yellow-300',
                                                            default => 'bg-gradient-to-br from-gray-100 to-gray-200 border-gray-300',
                                                        };
                                                    @endphp
                                                    <div class="rounded-xl p-3 border-2 {{ $bgClass }} shadow-sm hover:shadow-md transition-all duration-200">
                                                        <div class="text-sm font-bold text-gray-900 mb-2">{{ $clase->materia->nombre }}</div>
                                                        <div class="space-y-1 text-xs text-gray-700">
                                                            <div class="flex items-center justify-center">
                                                                <svg class="w-3 h-3 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                                </svg>
                                                                {{ $clase->docente->nombre }}
                                                            </div>
                                                            <div class="flex items-center justify-center">
                                                                <svg class="w-3 h-3 mr-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                                </svg>
                                                                {{ $clase->espacio?->nombre ?? 'Sin asignar' }}
                                                            </div>
                                                            <div class="flex items-center justify-center">
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                                    {{ $clase->modalidad == 'presencial' ? 'bg-green-100 text-green-800' : 
                                                                       ($clase->modalidad == 'virtual' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                                    {{ ucfirst($clase->modalidad) }}
                                                                </span>
                                                            </div>
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
            @endif
        </div>
    </div>
@endsection
