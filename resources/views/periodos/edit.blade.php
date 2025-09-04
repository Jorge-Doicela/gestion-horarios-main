@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Período Académico</h1>
                <p class="text-gray-600">Modifique la información de: <span class="font-semibold text-cyan-600">{{ $periodo->nombre }}</span></p>
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
                <form action="{{ route('periodos.update', $periodo) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <!-- Nombre Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nombre del Período Académico
                                </span>
                            </label>
                            <input type="text" name="nombre" value="{{ old('nombre', $periodo->nombre) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: 2024-1, Semestre I 2024, Trimestre A">
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
                                        <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Fecha de Inicio
                                    </span>
                                </label>
                                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $periodo->fecha_inicio) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_inicio')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Fecha Fin Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Fecha de Finalización
                                    </span>
                                </label>
                                <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $periodo->fecha_fin) }}" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                @error('fecha_fin')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Estado Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Estado del Período
                                </span>
                            </label>
                            <select name="estado" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="activo" {{ old('estado', $periodo->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $periodo->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="finalizado" {{ old('estado', $periodo->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            @error('estado')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Information Display -->
                    <div class="bg-cyan-50/50 border border-cyan-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-cyan-800">Información Actual del Período</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-cyan-700">Nombre:</span>
                                <div class="text-gray-900 font-semibold">{{ $periodo->nombre }}</div>
                            </div>
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-cyan-700">Inicio:</span>
                                <div class="text-gray-900 font-semibold">{{ $periodo->fecha_inicio }}</div>
                            </div>
                            <div class="bg-white/70 px-3 py-2 rounded-lg">
                                <span class="font-medium text-cyan-700">Fin:</span>
                                <div class="text-gray-900 font-semibold">{{ $periodo->fecha_fin }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-cyan-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Período
                            </span>
                        </button>
                        <a href="{{ route('periodos.index') }}" 
                           class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-cyan-500 hover:text-cyan-600 transition-all duration-200 transform hover:scale-105 text-center">
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
