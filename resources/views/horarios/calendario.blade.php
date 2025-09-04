@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Calendario de Horarios</h1>
                <p class="text-gray-600">Visualice y gestione los horarios académicos del sistema</p>
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

            <!-- Period Selection Form -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('horarios.generar') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
                    @csrf
                    <div class="flex-1">
                        <label for="periodo_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Período Académico
                            </span>
                        </label>
                        <select name="periodo_id" id="periodo_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                            @foreach ($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $periodo_id == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-shrink-0">
                        <button type="submit" 
                                class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Generar Horarios Automáticamente
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Calendar Container -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div id="calendar" class="rounded-xl overflow-hidden"></div>
            </div>

            <!-- Conflicts Section -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-500 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Conflictos Detectados</h2>
                </div>
                
                @if ($conflictos->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg">¡Excelente! No se han detectado conflictos en los horarios.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($conflictos as $conflicto)
                            <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-red-800 font-medium">{{ $conflicto->motivo }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var events = [
                @foreach ($horarios as $h)
                    {
                        title: '{{ $h->materia->nombre }} - {{ $h->docente->nombre }}',
                        start: '{{ $h->dia->nombre }}T{{ \Carbon\Carbon::parse($h->hora->hora_inicio)->format('H:i:s') }}',
                        end: '{{ $h->dia->nombre }}T{{ \Carbon\Carbon::parse($h->hora->hora_fin)->format('H:i:s') }}',
                        extendedProps: {
                            espacio: '{{ $h->espacio->nombre ?? '-' }}',
                            paralelo: '{{ $h->paralelo->nombre }}',
                            modalidad: '{{ $h->modalidad }}'
                        }
                    },
                @endforeach
            ];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                slotMinTime: "07:00:00",
                slotMaxTime: "22:00:00",
                allDaySlot: false,
                events: events,
                eventClick: function(info) {
                    alert(
                        'Materia: ' + info.event.title +
                        '\nParalelo: ' + info.event.extendedProps.paralelo +
                        '\nEspacio: ' + info.event.extendedProps.espacio +
                        '\nModalidad: ' + info.event.extendedProps.modalidad
                    );
                },
                dayHeaderFormat: {
                    weekday: 'long'
                }
            });

            calendar.render();
        });
    </script>
@endsection
