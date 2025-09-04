@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-violet-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Nuevo Nivel Académico</h1>
                <p class="text-gray-600">Defina un nuevo nivel académico para el sistema de horarios</p>
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
                <form action="{{ route('niveles.store') }}" method="POST" class="space-y-6" data-validate="true">
                    @csrf

                    <!-- Nombre del Nivel Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Nombre del Nivel Académico
                            </span>
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="50"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Ej: Primero, Segundo, Tercero, Cuarto, Quinto, Sexto">
                        <div class="flex justify-between items-center">
                            <p class="text-sm text-gray-500">Ingrese el nombre descriptivo del nivel académico</p>
                            <div class="text-xs text-gray-500">
                                <span id="nombre-count">0</span>/50 caracteres
                            </div>
                        </div>
                        @error('nombre')
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Level Examples -->
                    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Ejemplos de Niveles Académicos</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Por Número:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Primero</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Segundo</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Tercero</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Cuarto</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Por Grado:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Básico</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Intermedio</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Avanzado</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Especialización</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Level Information -->
                    <div class="bg-violet-50/50 border border-violet-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-violet-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-violet-800">Información sobre Niveles</h3>
                        </div>
                        <div class="text-sm text-violet-700 space-y-2">
                            <p>• Los niveles académicos organizan los cursos por grado de complejidad</p>
                            <p>• Cada nivel puede contener múltiples materias y paralelos</p>
                            <p>• Se utilizan para estructurar los horarios académicos</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-violet-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-violet-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Crear Nivel
                            </span>
                        </button>
                        <a href="{{ route('niveles.index') }}" 
                           class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-violet-500 hover:text-violet-600 transition-all duration-200 transform hover:scale-105 text-center">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contador de caracteres para nombre
            const nombreInput = document.querySelector('input[name="nombre"]');
            const nombreCount = document.getElementById('nombre-count');
            
            if (nombreInput && nombreCount) {
                nombreInput.addEventListener('input', function() {
                    nombreCount.textContent = this.value.length;
                    
                    if (this.value.length > 40) {
                        nombreCount.classList.add('text-yellow-600');
                    } else {
                        nombreCount.classList.remove('text-yellow-600');
                    }
                    
                    if (this.value.length >= 50) {
                        nombreCount.classList.add('text-red-600');
                    } else {
                        nombreCount.classList.remove('text-red-600');
                    }
                });
            }
        });
    </script>
@endsection
