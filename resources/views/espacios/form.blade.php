@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Nombre *</span>
        </label>
        <input type="text" name="nombre" value="{{ old('nombre', $espacio->nombre ?? '') }}" required
            maxlength="100"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
        @error('nombre')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                Tipo *</span>
        </label>
        @php($tipos = ['aula', 'laboratorio', 'cancha', 'aula interactiva', 'otro'])
        <select name="tipo" required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
            <option value="">Seleccione un tipo</option>
            @foreach ($tipos as $tipo)
                <option value="{{ $tipo }}" {{ old('tipo', $espacio->tipo ?? '') === $tipo ? 'selected' : '' }}>
                    {{ ucfirst($tipo) }}</option>
            @endforeach
        </select>
        @error('tipo')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
                Ubicación</span>
        </label>
        <input type="text" name="ubicacion" value="{{ old('ubicacion', $espacio->ubicacion ?? '') }}" maxlength="255"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
        @error('ubicacion')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Disponibilidad *</span>
        </label>
        <div class="flex items-center space-x-3">
            <input type="hidden" name="disponible" value="0">
            <input type="checkbox" name="disponible" id="disponible" value="1"
                {{ old('disponible', $espacio->disponible ?? true) ? 'checked' : '' }}
                class="h-5 w-5 text-indigo-600 border-gray-300 rounded">
            <label for="disponible" class="text-sm text-gray-700">Disponible</label>
        </div>
        @error('disponible')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Modalidad *</span>
        </label>
        @php($modalidades = ['presencial', 'virtual', 'hibrida'])
        <select name="modalidad" required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
            <option value="">Seleccione modalidad</option>
            @foreach ($modalidades as $m)
                <option value="{{ $m }}"
                    {{ old('modalidad', $espacio->modalidad ?? '') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}
                </option>
            @endforeach
        </select>
        @error('modalidad')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0">
                    </path>
                </svg>
                Capacidad</span>
        </label>
        <input type="number" name="capacidad" min="1" max="1000"
            value="{{ old('capacidad', $espacio->capacidad ?? '') }}"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
        @error('capacidad')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6"></path>
                </svg>
                Equipamiento (mantenga Ctrl para seleccionar varios)</span>
        </label>
        @php($equipos = ['proyector', 'pizarra', 'audio', 'computadoras', 'laboratorio', 'acceso discapacidad'])
        @php($seleccion = array_map('strtolower', old('equipamiento', $espacio->equipamiento ?? [])))
        <select name="equipamiento[]" multiple size="6"
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/50 backdrop-blur-sm">
            @foreach ($equipos as $eq)
                <option value="{{ $eq }}" {{ in_array($eq, $seleccion ?? []) ? 'selected' : '' }}>
                    {{ ucfirst($eq) }}</option>
            @endforeach
        </select>
        @error('equipamiento')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="flex flex-col sm:flex-row gap-4 pt-6">
    <button type="submit"
        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
        <span class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            @isset($espacio)
                Actualizar Espacio
            @else
                Crear Espacio
            @endisset
        </span>
    </button>
    <a href="{{ route('espacios.index') }}"
        class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-indigo-500 hover:text-indigo-600 transition-all duration-200 transform hover:scale-105 text-center">
        <span class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
            Cancelar
        </span>
    </a>
</div>
