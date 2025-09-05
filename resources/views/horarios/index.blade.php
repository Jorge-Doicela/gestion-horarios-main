@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestión de Horarios</h1>
                <p class="text-gray-600">Visualización dinámica y filtrable de horarios académicos</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Horarios</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $horarios->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Activos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $horarios->where('estado', 'activo')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Suspendidos</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $horarios->where('estado', 'suspendido')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Finalizados</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $horarios->where('estado', 'finalizado')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                <a href="{{ route('horarios.create') }}"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Nuevo Horario
                    </span>
                </a>
                <a href="{{ route('horarios.calendario') }}"
                    class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Ver Calendario
                    </span>
                </a>
            </div>

            <!-- Export Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-8 animate-fade-in-up" style="animation-delay: 0.35s;">
                <div class="flex flex-col sm:flex-row gap-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0 sm:mr-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Exportar Todo:
                    </h3>
                    <a href="{{ route('horarios.export.excel') }}"
                        class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-4 py-2 rounded-lg font-medium hover:from-green-700 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Excel
                        </span>
                    </a>
                    <a href="{{ route('horarios.export.pdf') }}"
                        class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-lg font-medium hover:from-red-700 hover:to-pink-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            PDF
                        </span>
                    </a>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0 sm:mr-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        Exportar Filtrado:
                    </h3>
                    <a href="{{ route('horarios.export.excel.filtrado', request()->query()) }}"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Excel
                        </span>
                    </a>
                    <a href="{{ route('horarios.export.pdf.filtrado', request()->query()) }}"
                        class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-4 py-2 rounded-lg font-medium hover:from-orange-700 hover:to-red-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                            PDF
                        </span>
                    </a>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6 mb-6 animate-fade-in-up"
                style="animation-delay: 0.4s;">
                <form method="GET" action="{{ route('horarios.index') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Buscar
                                </span>
                            </label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por materia, docente, paralelo..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                        </div>

                        <!-- Carrera Filter -->
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
                            <select name="carrera_id" id="carreraFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todas las carreras</option>
                                @foreach ($carreras as $carrera)
                                    <option value="{{ $carrera->id }}"
                                        {{ request('carrera_id') == $carrera->id ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nivel Filter -->
                        <div class="space-y-2" id="nivelContainer" style="display: none;">
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
                            <select name="nivel_id" id="nivelFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todos los niveles</option>
                                @foreach ($niveles as $nivel)
                                    <option value="{{ $nivel->id }}"
                                        {{ request('nivel_id') == $nivel->id ? 'selected' : '' }}>
                                        {{ $nivel->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Paralelo Filter -->
                        <div class="space-y-2" id="paraleloContainer" style="display: none;">
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
                            <select name="paralelo_id" id="paraleloFilter"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todos los paralelos</option>
                                @foreach ($paralelos as $paralelo)
                                    <option value="{{ $paralelo->id }}" data-nivel="{{ $paralelo->nivel_id }}"
                                        data-carrera="{{ $paralelo->carrera_id }}"
                                        {{ request('paralelo_id') == $paralelo->id ? 'selected' : '' }}>
                                        {{ $paralelo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Docente Filter -->
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
                            <select name="docente_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todos los docentes</option>
                                @foreach ($docentes as $docente)
                                    <option value="{{ $docente->id }}"
                                        {{ request('docente_id') == $docente->id ? 'selected' : '' }}>
                                        {{ $docente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Estado Filter -->
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
                            <select name="estado"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todos los estados</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado }}"
                                        {{ request('estado') == $estado ? 'selected' : '' }}>
                                        {{ ucfirst($estado) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Modalidad Filter -->
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
                            <select name="modalidad"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todas las modalidades</option>
                                @foreach ($modalidades as $modalidad)
                                    <option value="{{ $modalidad }}"
                                        {{ request('modalidad') == $modalidad ? 'selected' : '' }}>
                                        {{ ucfirst($modalidad) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Período Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Período
                                </span>
                            </label>
                            <select name="periodo_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="">Todos los períodos</option>
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ request('periodo_id') == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <!-- View Type -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                    Vista
                                </span>
                            </label>
                            <select name="view_type" id="viewType"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="table" {{ request('view_type', 'table') == 'table' ? 'selected' : '' }}>
                                    Tabla General</option>
                                <option value="paralelo" {{ request('view_type') == 'paralelo' ? 'selected' : '' }}>Por
                                    Paralelo</option>
                                <option value="docente" {{ request('view_type') == 'docente' ? 'selected' : '' }}>Por
                                    Docente</option>
                                <option value="dia" {{ request('view_type') == 'dia' ? 'selected' : '' }}>Por Día
                                </option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                                    </svg>
                                    Ordenar
                                </span>
                            </label>
                            <select name="sort_by"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
                                <option value="created_at"
                                    {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Fecha Creación
                                </option>
                                <option value="materia" {{ request('sort_by') == 'materia' ? 'selected' : '' }}>Materia
                                </option>
                                <option value="docente" {{ request('sort_by') == 'docente' ? 'selected' : '' }}>Docente
                                </option>
                                <option value="paralelo" {{ request('sort_by') == 'paralelo' ? 'selected' : '' }}>Paralelo
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                        </path>
                                    </svg>
                                    Filtrar
                                </span>
                            </button>
                            <a href="{{ route('horarios.index') }}"
                                class="bg-gray-500 text-white px-6 py-2 rounded-xl font-semibold hover:bg-gray-600 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Limpiar
                                </span>
                            </a>
                        </div>

                        <div class="text-sm text-gray-600">
                            Mostrando {{ $horarios->firstItem() ?? 0 }} - {{ $horarios->lastItem() ?? 0 }} de
                            {{ $horarios->total() }} resultados
                        </div>
                    </div>
                </form>
            </div>

            <!-- Dynamic View Content -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden animate-fade-in-up"
                style="animation-delay: 0.5s;">
                @php
                    $viewType = request('view_type', 'table');
                @endphp

                @if ($viewType === 'table')
                    <!-- Table View -->
                    @include('horarios.partials.table-view')
                @elseif($viewType === 'paralelo')
                    <!-- Paralelo View -->
                    @include('horarios.partials.paralelo-view')
                @elseif($viewType === 'docente')
                    <!-- Docente View -->
                    @include('horarios.partials.docente-view')
                @elseif($viewType === 'dia')
                    <!-- Day View -->
                    @include('horarios.partials.day-view')
                @endif
            </div>
        </div>
    </div>

    <script>
        // Auto-submit form when view type changes
        document.getElementById('viewType').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Filtros progresivos: Carrera -> Nivel -> Paralelo
        (function() {
            const carreraFilter = document.getElementById('carreraFilter');
            const nivelFilter = document.getElementById('nivelFilter');
            const paraleloFilter = document.getElementById('paraleloFilter');
            const nivelContainer = document.getElementById('nivelContainer');
            const paraleloContainer = document.getElementById('paraleloContainer');

            if (!carreraFilter || !nivelFilter || !paraleloFilter) return;

            // Función para filtrar niveles disponibles basándose en paralelos de la carrera seleccionada
            function filtrarNivelesPorCarrera(carreraId) {
                if (!carreraId) {
                    // Si no hay carrera seleccionada, ocultar nivel y paralelo
                    nivelContainer.style.display = 'none';
                    paraleloContainer.style.display = 'none';
                    nivelFilter.value = '';
                    paraleloFilter.value = '';
                    return;
                }

                // Mostrar contenedor de nivel
                nivelContainer.style.display = 'block';

                // Obtener todos los paralelos de la carrera seleccionada
                const paralelos = paraleloFilter.querySelectorAll('option[data-carrera]');
                const nivelesDisponibles = new Set();

                paralelos.forEach(option => {
                    if (option.dataset.carrera === carreraId) {
                        nivelesDisponibles.add(option.dataset.nivel);
                    }
                });

                // Filtrar opciones de nivel
                const nivelOptions = nivelFilter.querySelectorAll('option');
                nivelOptions.forEach(option => {
                    if (option.value === '') return; // Mantener "Todos los niveles"
                    option.style.display = nivelesDisponibles.has(option.value) ? '' : 'none';
                });

                // Limpiar selección de nivel y paralelo
                nivelFilter.value = '';
                paraleloFilter.value = '';
                paraleloContainer.style.display = 'none';
            }

            // Función para filtrar paralelos basándose en carrera y nivel seleccionados
            function filtrarParalelosPorCarreraYNivel(carreraId, nivelId) {
                if (!carreraId || !nivelId) {
                    paraleloContainer.style.display = 'none';
                    paraleloFilter.value = '';
                    return;
                }

                // Mostrar contenedor de paralelo
                paraleloContainer.style.display = 'block';

                // Filtrar opciones de paralelo
                const paraleloOptions = paraleloFilter.querySelectorAll('option');
                paraleloOptions.forEach(option => {
                    if (option.value === '') return; // Mantener "Todos los paralelos"
                    const optCarrera = option.dataset.carrera;
                    const optNivel = option.dataset.nivel;
                    const visible = optCarrera === carreraId && optNivel === nivelId;
                    option.style.display = visible ? '' : 'none';
                    if (!visible && option.selected) option.selected = false;
                });
            }

            // Event listeners
            carreraFilter.addEventListener('change', function() {
                const carreraId = this.value;
                filtrarNivelesPorCarrera(carreraId);
            });

            nivelFilter.addEventListener('change', function() {
                const carreraId = carreraFilter.value;
                const nivelId = this.value;
                filtrarParalelosPorCarreraYNivel(carreraId, nivelId);
            });

            // Inicializar estado basándose en valores existentes
            const carreraInicial = carreraFilter.value;
            const nivelInicial = nivelFilter.value;

            if (carreraInicial) {
                filtrarNivelesPorCarrera(carreraInicial);
                if (nivelInicial) {
                    filtrarParalelosPorCarreraYNivel(carreraInicial, nivelInicial);
                }
            }
        })();
    </script>
@endsection
