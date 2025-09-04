@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-600 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Nuevo Período Académico</h1>
                <p class="text-gray-600">Defina un nuevo período académico para el sistema de horarios</p>
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
                <form action="{{ route('periodos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <!-- Nombre Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nombre del Período Académico
                                </span>
                            </label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" required maxlength="100"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: 2024-1, Semestre I 2024, Trimestre A">
                            <div class="flex justify-between items-center">
                                <p class="text-sm text-gray-500">Ingrese el nombre del período académico</p>
                                <div class="text-xs text-gray-500">
                                    <span id="nombre-count">{{ strlen(old('nombre', '')) }}</span>/100 caracteres
                                </div>
                            </div>
                            @error('nombre')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date Range Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fecha Inicio Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Fecha de Inicio
                                    </span>
                                </label>
                                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_inicio')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fecha Fin Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Fecha de Finalización
                                    </span>
                                </label>
                                <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_fin')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Estado del Período
                                </span>
                            </label>
                            <select name="estado" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="finalizado" {{ old('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            @error('estado')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Period Examples -->
                    <div class="bg-orange-50/50 border border-orange-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-orange-800">Ejemplos de Períodos Académicos</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-orange-700">Por Semestre:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">2024-1 (Primer Semestre)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">2024-2 (Segundo Semestre)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">2025-1 (Primer Semestre)</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-orange-700">Por Trimestre:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Trimestre A 2024</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Trimestre B 2024</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Trimestre C 2024</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-orange-600 to-red-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Crear Período
                            </span>
                        </button>
                        <a href="{{ route('periodos.index') }}" 
                           class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-orange-500 hover:text-orange-600 transition-all duration-200 transform hover:scale-105 text-center">
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
                    
                    if (this.value.length > 80) {
                        nombreCount.classList.add('text-yellow-600');
                    } else {
                        nombreCount.classList.remove('text-yellow-600');
                    }
                    
                    if (this.value.length >= 100) {
                        nombreCount.classList.add('text-red-600');
                    } else {
                        nombreCount.classList.remove('text-red-600');
                    }
                });
            }

            // Validación de fechas
            const fechaInicioInput = document.querySelector('input[name="fecha_inicio"]');
            const fechaFinInput = document.querySelector('input[name="fecha_fin"]');
            
            if (fechaInicioInput && fechaFinInput) {
                fechaInicioInput.addEventListener('change', function() {
                    if (this.value && fechaFinInput.value) {
                        if (new Date(this.value) > new Date(fechaFinInput.value)) {
                            fechaFinInput.setCustomValidity('La fecha de fin debe ser posterior a la fecha de inicio');
                        } else {
                            fechaFinInput.setCustomValidity('');
                        }
                    }
                });
                
                fechaFinInput.addEventListener('change', function() {
                    if (this.value && fechaInicioInput.value) {
                        if (new Date(this.value) < new Date(fechaInicioInput.value)) {
                            this.setCustomValidity('La fecha de fin debe ser posterior a la fecha de inicio');
                        } else {
                            this.setCustomValidity('');
                        }
                    }
                });
            }
        });
    </script>
@endsection
