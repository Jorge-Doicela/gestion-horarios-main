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
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Docente</h1>
                <p class="text-gray-600">Modifique la información de: <span class="font-semibold text-blue-600">{{ $docente->nombre }}</span></p>
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

            <!-- Current Information Display -->
            <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-6 mb-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-center mb-4">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-800">Información Actual del Docente</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                    <div class="bg-white/70 px-4 py-3 rounded-lg">
                        <span class="font-medium text-blue-700">Nombre:</span>
                        <div class="text-gray-900 font-semibold">{{ $docente->nombre }}</div>
                    </div>
                    <div class="bg-white/70 px-4 py-3 rounded-lg">
                        <span class="font-medium text-blue-700">Email:</span>
                        <div class="text-gray-900 font-semibold">{{ $docente->email ?: 'No especificado' }}</div>
                    </div>
                    <div class="bg-white/70 px-4 py-3 rounded-lg">
                        <span class="font-medium text-blue-700">Título:</span>
                        <div class="text-gray-900 font-semibold">{{ $docente->titulo ?: 'No especificado' }}</div>
                    </div>
                    <div class="bg-white/70 px-4 py-3 rounded-lg">
                        <span class="font-medium text-blue-700">Especialidad:</span>
                        <div class="text-gray-900 font-semibold">{{ $docente->especialidad ?: 'No especificada' }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="font-medium text-blue-700">Materias asignadas:</span>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse($docente->materias as $materia)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $materia->codigo }} - {{ $materia->nombre }}
                            </span>
                        @empty
                            <span class="text-gray-500 text-sm">No hay materias asignadas</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-8 animate-fade-in-up" style="animation-delay: 0.3s;">
                <form action="{{ route('docentes.update', $docente) }}" method="POST" class="space-y-6">
                    @method('PUT')
                    @include('docentes.form')
                </form>
            </div>
        </div>
    </div>
@endsection
