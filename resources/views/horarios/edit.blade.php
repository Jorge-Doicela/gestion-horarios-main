@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Horario</h1>
                <p class="text-gray-600">Modifique la información del horario: <span
                        class="font-semibold text-indigo-600">{{ $horario->materia->nombre }} -
                        {{ $horario->paralelo->nombre }}</span></p>
            </div>

            <!-- Status Warning -->
            @if ($horario->estado !== 'activo')
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                        <div>
                            <h3 class="font-semibold">Horario {{ ucfirst($horario->estado) }}</h3>
                            <p class="text-sm">Este horario está <strong>{{ $horario->estado }}</strong> y no puede ser
                                modificado.</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.2s;">
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

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-8 animate-fade-in-up"
                style="animation-delay: 0.3s;">
                <form action="{{ route('horarios.update', $horario->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php $disabled = $horario->estado !== 'activo' ? 'disabled' : ''; @endphp

                    <!-- Basic Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Carrera Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    </svg>
                                    Carrera
                                </span>
                            </label>
                            <select name="carrera_id" id="carreraSelect" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->id }}"
                                        {{ optional($horario->paralelo)->carrera_id == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('carrera_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- Nivel Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18"></path>
                                    </svg>
                                    Nivel
                                </span>
                            </label>
                            <select name="nivel_id" id="nivelSelect" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($niveles as $nivel)
                                    <option value="{{ $nivel->id }}"
                                        {{ optional($horario->paralelo)->nivel_id == $nivel->id ? 'selected' : '' }}>
                                        {{ $nivel->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nivel_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
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
                                    Paralelo
                                </span>
                            </label>
                            <select name="paralelo_id" id="paraleloSelect" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($paralelos as $paralelo)
                                    <option value="{{ $paralelo->id }}" data-nivel="{{ $paralelo->nivel_id }}"
                                        data-carrera="{{ $paralelo->carrera_id }}"
                                        {{ $horario->paralelo_id == $paralelo->id ? 'selected' : '' }}>
                                        {{ $paralelo->nombre }}
                                    </option>
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
                                    Materia
                                </span>
                            </label>
                            <select name="materia_id" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($materias as $materia)
                                    <option value="{{ $materia->id }}"
                                        {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('materia_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Docente Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Docente
                                </span>
                            </label>
                            <select name="docente_id" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($docentes as $docente)
                                    <option value="{{ $docente->id }}"
                                        {{ $horario->docente_id == $docente->id ? 'selected' : '' }}>
                                        {{ $docente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('docente_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
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
                            <select name="espacio_id" {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <option value="">-- Ninguno --</option>
                                @foreach ($espacios as $espacio)
                                    <option value="{{ $espacio->id }}"
                                        {{ $horario->espacio_id == $espacio->id ? 'selected' : '' }}>
                                        {{ $espacio->nombre }} ({{ $espacio->tipo }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-gray-500 text-sm">Requerido si la modalidad es presencial o híbrida</small>
                            @error('espacio_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Schedule Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Día Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Día
                                </span>
                            </label>
                            <select name="dia_id" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($dias as $dia)
                                    <option value="{{ $dia->id }}"
                                        {{ $horario->dia_id == $dia->id ? 'selected' : '' }}>
                                        {{ $dia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dia_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Hora Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Hora
                                </span>
                            </label>
                            <select name="hora_id" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($horas as $hora)
                                    <option value="{{ $hora->id }}"
                                        {{ $horario->hora_id == $hora->id ? 'selected' : '' }}>
                                        {{ $hora->hora_inicio }} - {{ $hora->hora_fin }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hora_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Period and Dates Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                    Período Académico
                                </span>
                            </label>
                            <select name="periodo_academico_id" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ $horario->periodo_academico_id == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('periodo_academico_id')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

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
                                    Fecha Inicio
                                </span>
                            </label>
                            <input type="date" name="fecha_inicio" value="{{ $horario->fecha_inicio }}" required
                                {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
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
                                    Fecha Fin
                                </span>
                            </label>
                            <input type="date" name="fecha_fin" value="{{ $horario->fecha_fin }}" required
                                {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                            @error('fecha_fin')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Modality and Status Section -->
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
                                    Modalidad
                                </span>
                            </label>
                            <select name="modalidad" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <option value="presencial" {{ $horario->modalidad == 'presencial' ? 'selected' : '' }}>
                                    Presencial</option>
                                <option value="virtual" {{ $horario->modalidad == 'virtual' ? 'selected' : '' }}>Virtual
                                </option>
                                <option value="hibrida" {{ $horario->modalidad == 'hibrida' ? 'selected' : '' }}>Híbrida
                                </option>
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
                                    Estado
                                </span>
                            </label>
                            <select name="estado" required {{ $disabled }}
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <option value="activo" {{ $horario->estado == 'activo' ? 'selected' : '' }}>Activo
                                </option>
                                <option value="suspendido" {{ $horario->estado == 'suspendido' ? 'selected' : '' }}>
                                    Suspendido</option>
                                <option value="finalizado" {{ $horario->estado == 'finalizado' ? 'selected' : '' }}>
                                    Finalizado</option>
                            </select>
                            @error('estado')
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
                        <textarea name="observaciones" rows="4" {{ $disabled }}
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm resize-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                            placeholder="Agregue observaciones adicionales sobre el horario...">{{ $horario->observaciones }}</textarea>
                        @error('observaciones')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Current Information Display -->
                    <div class="bg-indigo-50/50 border border-indigo-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-indigo-800">Información Actual del Horario</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-indigo-700">Materia:</span>
                                <div class="text-gray-900 font-semibold">{{ $horario->materia->nombre }}</div>
                            </div>
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-indigo-700">Paralelo:</span>
                                <div class="text-gray-900 font-semibold">{{ $horario->paralelo->nombre }}</div>
                            </div>
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-indigo-700">Docente:</span>
                                <div class="text-gray-900 font-semibold">{{ $horario->docente->nombre }}</div>
                            </div>
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-indigo-700">Estado:</span>
                                <div class="text-gray-900 font-semibold capitalize">{{ $horario->estado }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" {{ $disabled }}
                            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Horario
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
            const carreraSelect = document.getElementById('carreraSelect');
            const nivelSelect = document.getElementById('nivelSelect');
            const paraleloSelect = document.getElementById('paraleloSelect');
            if (!paraleloSelect) return;

            function filtrarParalelos() {
                const nivelId = nivelSelect ? nivelSelect.value : '';
                const carreraId = carreraSelect ? carreraSelect.value : '';
                const options = paraleloSelect.querySelectorAll('option');
                options.forEach((opt, idx) => {
                    if (idx === 0) return;
                    const optNivel = opt.getAttribute('data-nivel');
                    const optCarrera = opt.getAttribute('data-carrera');
                    const visible = (!nivelId || optNivel === nivelId) && (!carreraId || optCarrera ===
                        carreraId);
                    opt.style.display = visible ? '' : 'none';
                    if (!visible && opt.selected) {
                        opt.selected = false;
                    }
                });
            }

            if (carreraSelect) carreraSelect.addEventListener('change', filtrarParalelos);
            if (nivelSelect) nivelSelect.addEventListener('change', filtrarParalelos);
            filtrarParalelos();
        });
    </script>
@endsection
