@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 animate-fade-in-up">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Rol</h1>
                <p class="text-gray-600">Modifique el rol: <span class="font-semibold text-emerald-600">{{ $role->name }}</span></p>
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
                <form method="POST" action="{{ route('admin.roles.update', $role) }}" class="space-y-6">
            @csrf
            @method('PUT')

                    <!-- Role Name Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Nombre del Rol
                            </span>
                        </label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
                               placeholder="Ej: Administrador, Docente, Estudiante">
                        <p class="text-sm text-gray-500">El nombre debe ser único y descriptivo del rol</p>
            </div>

                    <!-- Current Permissions Info -->
                    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800">Permisos Actuales</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($role->permissions as $perm)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $perm->name }}
                                </span>
                            @empty
                                <span class="text-sm text-blue-700">Este rol no tiene permisos asignados</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Permissions Section -->
                    <div class="space-y-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Modificar Permisos del Rol
                            </span>
                        </label>
                        <p class="text-sm text-gray-600 mb-4">Seleccione los permisos que tendrá este rol en el sistema</p>
                        
                        <div class="bg-gray-50/50 rounded-xl border border-gray-200 p-6 max-h-96 overflow-y-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($permissions as $perm)
                                    <div class="flex items-center p-3 bg-white/70 rounded-lg border border-gray-200 hover:bg-emerald-50/50 transition-all duration-200">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" id="perm_{{ $perm->id }}"
                                               class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2"
                                               {{ in_array($perm->name, old('permissions', $role->permissions->pluck('name')->toArray())) ? 'checked' : '' }}>
                                        <label for="perm_{{ $perm->id }}" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer flex-1">
                                            {{ $perm->name }}
                                        </label>
                                    </div>
                    @endforeach
                </div>
            </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Total de permisos disponibles: <span class="font-semibold text-emerald-600">{{ $permissions->count() }}</span></span>
                            <button type="button" onclick="selectAllPermissions()" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                Seleccionar todos
                            </button>
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
                                Actualizar Rol
                            </span>
                        </button>
                        <a href="{{ route('admin.roles.index') }}" 
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

    <script>
        function selectAllPermissions() {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = !allChecked;
            });
            
            const button = event.target;
            button.textContent = allChecked ? 'Seleccionar todos' : 'Deseleccionar todos';
        }
    </script>
@endsection
