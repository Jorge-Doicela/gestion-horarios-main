@csrf

<!-- Personal Information Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Nombre Field -->
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Nombre Completo
            </span>
        </label>
        <input type="text" name="nombre" value="{{ old('nombre', $docente->nombre ?? '') }}" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
               placeholder="Ej: Dr. Juan Pérez García">
    </div>

    <!-- Email Field -->
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Correo Electrónico
            </span>
        </label>
        <input type="email" name="email" value="{{ old('email', $docente->email ?? '') }}" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
               placeholder="Ej: juan.perez@universidad.edu">
    </div>
</div>

<!-- Academic Information Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Título Field -->
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                Título Académico
            </span>
        </label>
        <input type="text" name="titulo" value="{{ old('titulo', $docente->titulo ?? '') }}" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
               placeholder="Ej: Doctor en Ciencias, Magíster en Educación">
    </div>

    <!-- Especialidad Field -->
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Especialidad
            </span>
        </label>
        <input type="text" name="especialidad" value="{{ old('especialidad', $docente->especialidad ?? '') }}" required
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm"
               placeholder="Ej: Matemáticas Aplicadas, Física Cuántica">
    </div>
</div>

<!-- Subjects Selection Section -->
<div class="space-y-2">
    <label class="block text-sm font-semibold text-gray-700">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Materias que Imparte
        </span>
    </label>
    <div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
        <p class="text-sm text-blue-700 mb-3">Seleccione las materias que este docente puede impartir:</p>
        <select name="materias[]" multiple 
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm min-h-[120px]">
            @foreach ($materias as $materia)
                <option value="{{ $materia->id }}"
                    {{ isset($materiasSeleccionadas) && in_array($materia->id, $materiasSeleccionadas) ? 'selected' : '' }}>
                    {{ $materia->codigo }} - {{ $materia->nombre }} ({{ $materia->carrera->nombre }})
                </option>
            @endforeach
        </select>
        <p class="text-xs text-blue-600 mt-2">💡 Mantenga presionada la tecla Ctrl (Cmd en Mac) para seleccionar múltiples materias</p>
    </div>
</div>

<!-- Teacher Examples -->
<div class="bg-blue-50/50 border border-blue-200 rounded-xl p-4">
    <div class="flex items-center mb-3">
        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-sm font-semibold text-blue-800">Ejemplos de Información Docente</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
        <div class="space-y-1">
            <span class="font-medium text-blue-700">Títulos Comunes:</span>
            <div class="space-y-1">
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Doctor en Ciencias</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Magíster en Educación</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Ingeniero de Sistemas</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Licenciado en Matemáticas</div>
            </div>
        </div>
        <div class="space-y-1">
            <span class="font-medium text-blue-700">Especialidades:</span>
            <div class="space-y-1">
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Matemáticas Aplicadas</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Física Cuántica</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Programación Avanzada</div>
                <div class="bg-white/70 px-2 py-1 rounded text-xs">Inteligencia Artificial</div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="flex flex-col sm:flex-row gap-4 pt-6">
    <button type="submit" 
            class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
        <span class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ isset($docente) ? 'Actualizar Docente' : 'Crear Docente' }}
        </span>
    </button>
    <a href="{{ route('docentes.index') }}" 
       class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition-all duration-200 transform hover:scale-105 text-center">
        <span class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Cancelar
        </span>
    </a>
</div>
