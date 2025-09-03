@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-cyan-600 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Permiso</h1>
                <p class="text-gray-600">Modifique el permiso: <span class="font-semibold text-cyan-600">{{ $permission->name }}</span></p>
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
                <form method="POST" action="{{ route('admin.permissions.update', $permission) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Permission Name Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Nombre del Permiso
                            </span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $permission->name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Ej: users.create, roles.edit, permissions.view">
                        <p class="text-sm text-gray-500">Use un formato descriptivo como: <code class="bg-gray-100 px-2 py-1 rounded text-xs">recurso.accion</code></p>
                    </div>

                    <!-- Current Permission Info -->
                    <div class="bg-green-50/50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-green-800">Información del Permiso</h3>
                        </div>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-green-700">ID del Permiso:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $permission->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700">Guard:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $permission->guard_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-green-700">Creado:</span>
                                <span class="font-mono bg-white/70 px-2 py-1 rounded text-xs">{{ $permission->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Examples -->
                    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Ejemplos de Permisos</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">CRUD Básico:</span>
                                <div class="space-y-1">
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">users.create</code>
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">users.edit</code>
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">users.view</code>
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">users.delete</code>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <span class="font-medium text-blue-700">Específicos:</span>
                                <div class="space-y-1">
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">admin.dashboard</code>
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">reports.export</code>
                                    <code class="block bg-white/70 px-2 py-1 rounded text-xs">settings.manage</code>
                                </div>
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
                                Actualizar Permiso
                            </span>
                        </button>
                        <a href="{{ route('admin.permissions.index') }}" 
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
