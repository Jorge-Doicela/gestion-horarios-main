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
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestión de Usuarios</h1>
                <p class="text-gray-600">Administre los usuarios del sistema y sus permisos</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 animate-fade-in-up"
                    style="animation-delay: 0.1s;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Action Bar -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 animate-fade-in-up"
                style="animation-delay: 0.2s;">
                <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <div class="bg-white/80 backdrop-blur-md rounded-xl px-4 py-2 border border-white/20">
                        <span class="text-sm text-gray-600">Total de usuarios:</span>
                        <span class="font-semibold text-indigo-600 ml-1">{{ $users->total() }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Usuario
                    </span>
                </a>
            </div>

            <!-- Filtros de búsqueda y rol -->
            <form method="GET" class="flex flex-col sm:flex-row items-center mb-4 space-y-2 sm:space-y-0 sm:space-x-4">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar usuario o email"
                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-64">

                <select name="role"
                    class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                <div class="flex space-x-2">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-all">
                        Filtrar
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-all">
                        Limpiar
                    </a>
                </div>
            </form>


            <!-- Users Table -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 overflow-hidden animate-fade-in-up"
                style="animation-delay: 0.3s;">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Usuario
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Roles
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50/50 transition-all duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mr-4">
                                                <span
                                                    class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $user->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            @forelse ($user->roles as $role)
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if ($role->name === 'Administrador') bg-red-100 text-red-800
                                            @elseif($role->name === 'Docente') bg-blue-100 text-blue-800
                                            @elseif($role->name === 'Estudiante') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Sin roles
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105">
                                                Editar
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 transform hover:scale-105">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12 text-gray-500">
                                        No hay usuarios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination con rango -->
                @if ($users->hasPages())
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center bg-gray-50/50 px-6 py-4 border-t border-gray-200 rounded-b-2xl mt-4">
                        <!-- Total de resultados -->
                        <div class="text-sm text-gray-600 mb-2 sm:mb-0">
                            Mostrando
                            <span class="font-semibold">{{ $users->firstItem() }}</span> -
                            <span class="font-semibold">{{ $users->lastItem() }}</span> de
                            <span class="font-semibold">{{ $users->total() }}</span> usuarios
                        </div>

                        <!-- Links de paginación -->
                        <div>
                            {{ $users->onEachSide(1)->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
