@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Nuevo Horario</h1>
                <p class="text-gray-600">Registre un nuevo horario académico paso a paso</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold mb-2">Por favor, corrija los siguientes errores:</h3>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Progress Bar -->
            <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.15s;">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="step-indicator active" data-step="1">
                            <div
                                class="w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                                1</div>
                            <span class="text-sm font-medium text-gray-700 ml-2">Información Básica</span>
                        </div>
                        <div class="step-indicator" data-step="2">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">
                                2</div>
                            <span class="text-sm font-medium text-gray-500 ml-2">Horario</span>
                        </div>
                        <div class="step-indicator" data-step="3">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">
                                3</div>
                            <span class="text-sm font-medium text-gray-500 ml-2">Configuración</span>
                        </div>
                        <div class="step-indicator" data-step="4">
                            <div
                                class="w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold">
                                4</div>
                            <span class="text-sm font-medium text-gray-500 ml-2">Revisión</span>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="progress-bar bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full transition-all duration-500"
                        style="width: 25%"></div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-8 animate-fade-in-up"
                style="animation-delay: 0.2s;">
                <form action="{{ route('horarios.store') }}" method="POST" class="space-y-6" data-validate="true"
                    id="horarioForm">
                    @csrf

                    <!-- Step 1: Basic Information -->
                    <div class="step-content" id="step1">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Información Básica</h2>
                            <p class="text-gray-600">Seleccione el paralelo y la materia para el horario</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Paralelo Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        Paralelo *
                                    </span>
                                </label>
                                <select name="paralelo_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione un paralelo</option>
                                    @foreach ($paralelos as $paralelo)
                                        <option value="{{ $paralelo->id }}">{{ $paralelo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('paralelo_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Materia Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        Materia *
                                    </span>
                                </label>
                                <select name="materia_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione una materia</option>
                                    @foreach ($materias as $materia)
                                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('materia_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Docente Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Docente *
                                    </span>
                                </label>
                                <select name="docente_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione un docente</option>
                                    @foreach ($docentes as $docente)
                                        <option value="{{ $docente->id }}">{{ $docente->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('docente_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Periodo Académico Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Período Académico *
                                    </span>
                                </label>
                                <select name="periodo_academico_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione un período</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('periodo_academico_id')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Schedule Selection -->
                    <div class="step-content hidden" id="step2">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Selección de Horario</h2>
                            <p class="text-gray-600">Seleccione el día y hora para el horario</p>
                        </div>

                        <!-- Weekly Schedule Grid -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Horario Semanal</h3>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="grid grid-cols-6 gap-2">
                                    <!-- Time column -->
                                    <div class="text-center font-semibold text-gray-700 py-2">Hora</div>
                                    @foreach ($dias as $dia)
                                        <div class="text-center font-semibold text-gray-700 py-2">{{ $dia->nombre }}
                                        </div>
                                    @endforeach

                                    @foreach ($horas as $hora)
                                        <div class="text-center text-sm text-gray-600 py-2 border-b border-gray-200">
                                            {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }}<br>
                                            {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                                        </div>
                                        @foreach ($dias as $dia)
                                            <div class="schedule-cell border border-gray-200 rounded-lg p-2 text-center text-xs cursor-pointer hover:bg-blue-50 transition-colors duration-200"
                                                data-dia="{{ $dia->id }}" data-hora="{{ $hora->id }}"
                                                data-dia-nombre="{{ $dia->nombre }}"
                                                data-hora-texto="{{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}">
                                                <div class="text-gray-400">Disponible</div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Selected Schedule Display -->
                        <div class="bg-indigo-50 rounded-xl p-4 mb-6" id="selectedScheduleDisplay"
                            style="display: none;">
                            <h4 class="font-semibold text-indigo-800 mb-2">Horario Seleccionado:</h4>
                            <div class="flex items-center space-x-4">
                                <div class="bg-indigo-100 rounded-lg px-3 py-2">
                                    <span class="text-sm font-medium text-indigo-700" id="selectedDay">-</span>
                                </div>
                                <div class="bg-indigo-100 rounded-lg px-3 py-2">
                                    <span class="text-sm font-medium text-indigo-700" id="selectedTime">-</span>
                                </div>
                                <button type="button" id="clearSelection"
                                    class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Hidden inputs for form submission -->
                        <input type="hidden" name="dia_id" id="dia_id" required>
                        <input type="hidden" name="hora_id" id="hora_id" required>
                    </div>

                    <!-- Step 3: Configuration -->
                    <div class="step-content hidden" id="step3">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Configuración</h2>
                            <p class="text-gray-600">Configure la modalidad, estado y fechas del horario</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Modalidad Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Modalidad *
                                    </span>
                                </label>
                                <select name="modalidad" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione modalidad</option>
                                    <option value="presencial">Presencial</option>
                                    <option value="virtual">Virtual</option>
                                    <option value="hibrida">Híbrida</option>
                                </select>
                                @error('modalidad')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Estado Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Estado *
                                    </span>
                                </label>
                                <select name="estado" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione estado</option>
                                    <option value="activo">Activo</option>
                                    <option value="suspendido">Suspendido</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                                @error('estado')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Espacio Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Espacio
                                </span>
                            </label>
                            <select name="espacio_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">-- Ninguno --</option>
                                @foreach ($espacios as $espacio)
                                    <option value="{{ $espacio->id }}">{{ $espacio->nombre }} ({{ $espacio->tipo }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-gray-500 text-sm" id="espacioHelp">Opcional para modalidad virtual</small>
                            @error('espacio_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Dates Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fecha Inicio Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Fecha Inicio *
                                    </span>
                                </label>
                                <input type="date" name="fecha_inicio" required min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_inicio')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fecha Fin Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Fecha Fin *
                                    </span>
                                </label>
                                <input type="date" name="fecha_fin" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_fin')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Observaciones Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Observaciones
                                </span>
                            </label>
                            <textarea name="observaciones" rows="4" maxlength="500"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm resize-none"
                                placeholder="Agregue observaciones adicionales sobre el horario..."></textarea>
                            <div class="text-xs text-gray-500 text-right">
                                <span id="observaciones-count">0</span>/500 caracteres
                            </div>
                            @error('observaciones')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Step 4: Review -->
                    <div class="step-content hidden" id="step4">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Revisión Final</h2>
                            <p class="text-gray-600">Revise toda la información antes de crear el horario</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-4">Información Básica</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Paralelo:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-paralelo">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Materia:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-materia">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Docente:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-docente">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Período:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-periodo">-</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-4">Horario</h3>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Día:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-dia">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Hora:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-hora">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Modalidad:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-modalidad">-</span>
                                        </div>
                                        <div>
                                            <span class="text-sm font-medium text-gray-600">Estado:</span>
                                            <span class="text-sm text-gray-800 ml-2" id="review-estado">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h3 class="font-semibold text-gray-800 mb-4">Fechas</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Fecha Inicio:</span>
                                        <span class="text-sm text-gray-800 ml-2" id="review-fecha-inicio">-</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Fecha Fin:</span>
                                        <span class="text-sm text-gray-800 ml-2" id="review-fecha-fin">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="button" id="prevBtn"
                            class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition-all duration-200 transform hover:scale-105 text-center"
                            style="display: none;">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Anterior
                            </span>
                        </button>
                        <button type="button" id="nextBtn"
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                Siguiente
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </button>
                        <button type="submit" id="submitBtn"
                            class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105 shadow-lg"
                            style="display: none;">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Crear Horario
                            </span>
                        </button>
                        <a href="{{ route('horarios.index') }}"
                            class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition-all duration-200 transform hover:scale-105 text-center">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;

            // Elements
            const stepContents = document.querySelectorAll('.step-content');
            const stepIndicators = document.querySelectorAll('.step-indicator');
            const progressBar = document.querySelector('.progress-bar');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');

            // Schedule selection
            const scheduleCells = document.querySelectorAll('.schedule-cell');
            const selectedScheduleDisplay = document.getElementById('selectedScheduleDisplay');
            const clearSelection = document.getElementById('clearSelection');
            const diaInput = document.getElementById('dia_id');
            const horaInput = document.getElementById('hora_id');

            // Form validation
            const form = document.getElementById('horarioForm');
            const modalidadSelect = document.querySelector('select[name="modalidad"]');
            const espacioSelect = document.querySelector('select[name="espacio_id"]');
            const espacioHelp = document.getElementById('espacioHelp');

            // Initialize
            updateStepDisplay();
            setupScheduleSelection();
            setupFormValidation();

            // Step navigation
            nextBtn.addEventListener('click', function() {
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateStepDisplay();
                    }
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateStepDisplay();
                }
            });

            function updateStepDisplay() {
                // Hide all step contents
                stepContents.forEach(content => content.classList.add('hidden'));

                // Show current step
                document.getElementById(`step${currentStep}`).classList.remove('hidden');

                // Update indicators
                stepIndicators.forEach((indicator, index) => {
                    const stepNumber = index + 1;
                    const circle = indicator.querySelector('div');
                    const text = indicator.querySelector('span');

                    if (stepNumber < currentStep) {
                        // Completed
                        circle.className =
                            'w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-semibold';
                        text.className = 'text-sm font-medium text-gray-700 ml-2';
                    } else if (stepNumber === currentStep) {
                        // Current
                        circle.className =
                            'w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center text-sm font-semibold';
                        text.className = 'text-sm font-medium text-gray-700 ml-2';
                    } else {
                        // Future
                        circle.className =
                            'w-8 h-8 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm font-semibold';
                        text.className = 'text-sm font-medium text-gray-500 ml-2';
                    }
                });

                // Update progress bar
                const progress = (currentStep / totalSteps) * 100;
                progressBar.style.width = progress + '%';

                // Update buttons
                if (currentStep === 1) {
                    prevBtn.style.display = 'none';
                } else {
                    prevBtn.style.display = 'block';
                }

                if (currentStep === totalSteps) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                    updateReviewStep();
                } else {
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                }
            }

            function validateCurrentStep() {
                const currentStepElement = document.getElementById(`step${currentStep}`);
                const requiredFields = currentStepElement.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-500');
                    }
                });

                // Special validation for step 2
                if (currentStep === 2) {
                    if (!diaInput.value || !horaInput.value) {
                        alert('Por favor seleccione un día y hora del horario semanal.');
                        isValid = false;
                    }
                }

                return isValid;
            }

            function setupScheduleSelection() {
                scheduleCells.forEach(cell => {
                    cell.addEventListener('click', function() {
                        // Remove previous selection
                        scheduleCells.forEach(c => {
                            c.classList.remove('bg-indigo-100', 'border-indigo-300');
                            c.classList.add('border-gray-200');
                            c.innerHTML = '<div class="text-gray-400">Disponible</div>';
                        });

                        // Select current cell
                        this.classList.remove('border-gray-200');
                        this.classList.add('bg-indigo-100', 'border-indigo-300');
                        this.innerHTML =
                            '<div class="text-indigo-700 font-medium">Seleccionado</div>';

                        // Update hidden inputs
                        diaInput.value = this.dataset.dia;
                        horaInput.value = this.dataset.hora;

                        // Show selection display
                        selectedScheduleDisplay.style.display = 'block';
                        document.getElementById('selectedDay').textContent = this.dataset.diaNombre;
                        document.getElementById('selectedTime').textContent = this.dataset
                            .horaTexto;
                    });
                });

                clearSelection.addEventListener('click', function() {
                    scheduleCells.forEach(c => {
                        c.classList.remove('bg-indigo-100', 'border-indigo-300');
                        c.classList.add('border-gray-200');
                        c.innerHTML = '<div class="text-gray-400">Disponible</div>';
                    });
                    selectedScheduleDisplay.style.display = 'none';
                    diaInput.value = '';
                    horaInput.value = '';
                });
            }

            function setupFormValidation() {
                // Modalidad validation
                modalidadSelect.addEventListener('change', function() {
                    if (this.value === 'presencial' || this.value === 'hibrida') {
                        espacioSelect.required = true;
                        espacioHelp.textContent = 'Requerido para modalidad ' + this.value;
                        espacioHelp.className = 'text-red-500 text-sm';
                    } else {
                        espacioSelect.required = false;
                        espacioHelp.textContent = 'Opcional para modalidad virtual';
                        espacioHelp.className = 'text-gray-500 text-sm';
                    }
                });

                // Date validation
                const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
                const fechaFin = document.querySelector('input[name="fecha_fin"]');

                fechaInicio.addEventListener('change', function() {
                    if (this.value) {
                        fechaFin.min = this.value;
                    }
                });

                fechaFin.addEventListener('change', function() {
                    if (fechaInicio.value && this.value < fechaInicio.value) {
                        this.setCustomValidity('La fecha de fin debe ser posterior a la fecha de inicio');
                    } else {
                        this.setCustomValidity('');
                    }
                });

                // Observaciones counter
                const observacionesTextarea = document.querySelector('textarea[name="observaciones"]');
                const observacionesCount = document.getElementById('observaciones-count');

                if (observacionesTextarea && observacionesCount) {
                    observacionesTextarea.addEventListener('input', function() {
                        observacionesCount.textContent = this.value.length;

                        if (this.value.length > 450) {
                            observacionesCount.classList.add('text-yellow-600');
                        } else {
                            observacionesCount.classList.remove('text-yellow-600');
                        }

                        if (this.value.length >= 500) {
                            observacionesCount.classList.add('text-red-600');
                        } else {
                            observacionesCount.classList.remove('text-red-600');
                        }
                    });
                }
            }

            function updateReviewStep() {
                // Update review fields with form values
                const paraleloSelect = document.querySelector('select[name="paralelo_id"]');
                const materiaSelect = document.querySelector('select[name="materia_id"]');
                const docenteSelect = document.querySelector('select[name="docente_id"]');
                const periodoSelect = document.querySelector('select[name="periodo_academico_id"]');
                const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
                const fechaFin = document.querySelector('input[name="fecha_fin"]');

                document.getElementById('review-paralelo').textContent = paraleloSelect.options[paraleloSelect
                    .selectedIndex]?.text || '-';
                document.getElementById('review-materia').textContent = materiaSelect.options[materiaSelect
                    .selectedIndex]?.text || '-';
                document.getElementById('review-docente').textContent = docenteSelect.options[docenteSelect
                    .selectedIndex]?.text || '-';
                document.getElementById('review-periodo').textContent = periodoSelect.options[periodoSelect
                    .selectedIndex]?.text || '-';
                document.getElementById('review-dia').textContent = document.getElementById('selectedDay')
                    .textContent;
                document.getElementById('review-hora').textContent = document.getElementById('selectedTime')
                    .textContent;
                document.getElementById('review-modalidad').textContent = modalidadSelect.options[modalidadSelect
                    .selectedIndex]?.text || '-';
                document.getElementById('review-estado').textContent = document.querySelector(
                    'select[name="estado"]').options[document.querySelector('select[name="estado"]')
                    .selectedIndex]?.text || '-';
                document.getElementById('review-fecha-inicio').textContent = fechaInicio.value || '-';
                document.getElementById('review-fecha-fin').textContent = fechaFin.value || '-';
            }
        });
    </script>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-content {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .schedule-cell {
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .schedule-cell:hover {
            transform: scale(1.02);
        }
    </style>
@endsection
