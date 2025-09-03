@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Carrera</h1>
                <p class="text-gray-600">Modifique la información de: <span class="font-semibold text-emerald-600">{{ $carrera->nombre }}</span></p>
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
                <form action="{{ route('carreras.update', $carrera) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nombre Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Nombre de la Carrera
                            </span>
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre', $carrera->nombre) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Ej: Ingeniería en Sistemas, Medicina, Administración">
                        @error('nombre')
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Código Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                                Código de la Carrera
                            </span>
                        </label>
                        <input type="text" name="codigo" value="{{ old('codigo', $carrera->codigo) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Ej: IS, MED, ADM">
                        <p class="text-sm text-gray-500">Use un código corto y único para identificar la carrera</p>
                        @error('codigo')
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Descripción Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Descripción
                            </span>
                        </label>
                        <textarea name="descripcion" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm resize-none"
                                  placeholder="Describa brevemente los objetivos y características de la carrera...">{{ old('descripcion', $carrera->descripcion) }}</textarea>
                        <p class="text-sm text-gray-500">Proporcione una descripción detallada de la carrera académica</p>
                        @error('descripcion')
                            <div class="flex items-center text-red-600 text-sm mt-1">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Current Career Info -->
                    <div class="bg-green-50/50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-green-800">Información de la Carrera</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-green-700">ID de la Carrera:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $carrera->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700">Código Actual:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $carrera->codigo }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700">Creada:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $carrera->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Career Examples -->
                    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Ejemplos de Carreras</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Tecnológicas:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Ingeniería en Sistemas (IS)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Ingeniería en Software (ISW)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Tecnología en Informática (TI)</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Salud:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Medicina (MED)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Enfermería (ENF)</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">Fisioterapia (FIS)</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Actualizar Carrera
                            </span>
                        </button>
                        <a href="{{ route('carreras.index') }}" 
                           class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-emerald-500 hover:text-emerald-600 transition-all duration-200 transform hover:scale-105 text-center">
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
