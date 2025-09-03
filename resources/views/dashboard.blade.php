@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="mb-8 animate-fade-in-up">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-blue-600 rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-8 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">¡Bienvenido, {{ Auth::user()->name }}!</h1>
                                <p class="text-indigo-100 text-lg">{{ __("You're logged in!") }}</p>
                                <p class="text-indigo-200 mt-2">Sistema de Gestión de Horarios Académicos</p>
                            </div>
                            <div class="hidden md:block">
                                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center animate-float">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    {{-- Botones de gestión para Administrador --}}
                    @role('Administrador')
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Panel de Administración
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

                            {{-- Usuarios --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.3s;">
                            <a href="{{ route('admin.users.index') }}" class="block p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Usuarios</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Roles --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.4s;">
                            <a href="{{ route('admin.roles.index') }}" class="block p-6 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Roles</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Permisos --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.5s;">
                            <a href="{{ route('admin.permissions.index') }}" class="block p-6 bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Permisos</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Carreras --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.6s;">
                            <a href="{{ route('carreras.index') }}" class="block p-6 bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Carreras</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Niveles --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.7s;">
                            <a href="{{ route('niveles.index') }}" class="block p-6 bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V4a1 1 0 011-1h2a1 1 0 011 1v3m0 0h8m-8 0v12a1 1 0 001 1h6a1 1 0 001-1V7a1 1 0 00-1-1H9a1 1 0 00-1 1v12a1 1 0 001 1h6a1 1 0 001-1V7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Niveles</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Materias --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.8s;">
                            <a href="{{ route('materias.index') }}" class="block p-6 bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Materias</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Paralelos --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 0.9s;">
                            <a href="{{ route('paralelos.index') }}" class="block p-6 bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Paralelos</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Docentes --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 1.0s;">
                            <a href="{{ route('docentes.index') }}" class="block p-6 bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Docentes</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Espacios --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 1.1s;">
                            <a href="{{ route('espacios.index') }}" class="block p-6 bg-gradient-to-br from-gray-500 to-gray-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Espacios</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Periodos Académicos --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 1.2s;">
                            <a href="{{ route('periodos.index') }}" class="block p-6 bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Periodos</h3>
                                </div>
                            </a>
                        </div>

                            {{-- Horarios --}}
                        <div class="group animate-fade-in-up" style="animation-delay: 1.3s;">
                            <a href="{{ route('horarios.index') }}" class="block p-6 bg-gradient-to-br from-cyan-500 to-cyan-600 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group-hover:scale-105">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 group-hover:bg-white/30 transition-colors duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-sm">Horarios</h3>
                                </div>
                            </a>
                        </div>

                </div>
            </div>
            @endrole

        </div>
    </div>
@endsection
