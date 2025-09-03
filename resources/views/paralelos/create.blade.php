@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Nuevo Paralelo</h1>
                <p class="text-gray-600">Registre un nuevo paralelo en el sistema de horarios</p>
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
                <form action="{{ route('paralelos.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <!-- Nombre Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Nombre del Paralelo
                                </span>
                            </label>
                            <input type="text" name="nombre" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                   placeholder="Ej: A, B, C, 1, 2, 3">
                        </div>

                        <!-- Carrera and Nivel Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Carrera Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                        Carrera
                                    </span>
                                </label>
                                <select name="carrera_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione una carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nivel Field -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Nivel
                                    </span>
                                </label>
                                <select name="nivel_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                    <option value="">Seleccione un nivel</option>
                                    @foreach ($niveles as $nivel)
                                        <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Parallel Examples -->
                    <div class="bg-emerald-50/50 border border-emerald-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-emerald-800">Ejemplos de Nombres de Paralelos</h3>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-emerald-700">Letras:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">A</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">B</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">C</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-emerald-700">Números:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">1</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">2</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">3</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-emerald-700">Mixtos:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">A1</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">B2</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">C3</div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-emerald-700">Especiales:</span>
                                <div class="space-y-1">
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">MAÑANA</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">TARDE</div>
                                    <div class="bg-white/70 px-2 py-1 rounded text-xs">NOCHE</div>
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
                                Crear Paralelo
                            </span>
                        </button>
                        <a href="{{ route('paralelos.index') }}" 
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
