@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Materia</h1>
                <p class="text-gray-600">Modifique la información de: <span class="font-semibold text-blue-600">{{ $materia->nombre }}</span></p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <form action="{{ route('materias.update', $materia) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nombre de la Materia
                                </span>
                            </label>
                            <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: Matemáticas I, Programación, Física">
                        </div>

                        <!-- Código Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                    Código de la Materia
                                </span>
                            </label>
                            <input type="text" name="codigo" value="{{ old('codigo', $materia->codigo) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: MAT101, PROG201, FIS301">
                        </div>
                    </div>

                    <!-- Academic Information Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Carrera Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Carrera
                                </span>
                            </label>
                            <select name="carrera_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->id }}" {{ $carrera->id == $materia->carrera_id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nivel Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Nivel Académico
                                </span>
                            </label>
                            <select name="nivel_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @foreach ($niveles as $nivel)
                                    <option value="{{ $nivel->id }}" {{ $nivel->id == $materia->nivel_id ? 'selected' : '' }}>
                                        {{ $nivel->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Academic Details Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Créditos Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    Créditos
                                </span>
                            </label>
                            <input type="number" name="creditos" value="{{ old('creditos', $materia->creditos) }}" min="0" max="10" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: 3, 4, 6">
                        </div>

                        <!-- Tipo Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Tipo de Materia
                                </span>
                            </label>
                            <select name="tipo" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="teorica" {{ $materia->tipo == 'teorica' ? 'selected' : '' }}>Teórica</option>
                                <option value="practica" {{ $materia->tipo == 'practica' ? 'selected' : '' }}>Práctica</option>
                                <option value="mixta" {{ $materia->tipo == 'mixta' ? 'selected' : '' }}>Mixta</option>
                            </select>
                        </div>
                    </div>

                    <!-- Current Subject Info -->
                    <div class="bg-green-50/50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-green-800">Información de la Materia</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-green-700">ID de la Materia:</span>
                                    <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $materia->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-green-700">Código Actual:</span>
                                    <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $materia->codigo }}</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-green-700">Carrera:</span>
                                    <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $materia->carrera->nombre }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-green-700">Creada:</span>
                                    <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $materia->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subject Examples -->
                    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Ejemplos de Materias</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Básicas:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Matemáticas I (MAT101)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Física I (FIS101)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Química I (QUI101)</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Especializadas:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Programación (PROG201)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Base de Datos (BD301)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Redes (RED401)</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Prácticas:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Laboratorio (LAB201)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Taller (TAL301)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Práctica (PRA401)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-blue-600 to-cyan-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Materia
                            </span>
                        </button>
                        <a href="{{ route('materias.index') }}" 
                           class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-blue-500 hover:text-blue-600 transition-all duration-200 transform hover:scale-105 text-center">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancelar
                            </span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
