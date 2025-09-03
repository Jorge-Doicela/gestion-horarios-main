@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Espacio</h1>

        <form action="{{ route('espacios.update', $espacio) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $espacio->nombre) }}"
                    class="border rounded px-2 py-1 w-full">
                @error('nombre')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Tipo</label>
                <select name="tipo" class="border rounded px-2 py-1 w-full">
                    @foreach (['aula', 'laboratorio', 'cancha', 'aula interactiva', 'otro'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo', $espacio->tipo) == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}</option>
                    @endforeach
                </select>
                @error('tipo')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Modalidad</label>
                <select name="modalidad" class="border rounded px-2 py-1 w-full">
                    @foreach (['presencial', 'virtual', 'hibrida'] as $modalidad)
                        <option value="{{ $modalidad }}"
                            {{ old('modalidad', $espacio->modalidad) == $modalidad ? 'selected' : '' }}>
                            {{ ucfirst($modalidad) }}</option>
                    @endforeach
                </select>
                @error('modalidad')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Capacidad</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', $espacio->capacidad) }}"
                    class="border rounded px-2 py-1 w-full">
                @error('capacidad')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Ubicación</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion', $espacio->ubicacion) }}"
                    class="border rounded px-2 py-1 w-full">
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="disponible" value="1"
                        {{ old('disponible', $espacio->disponible) ? 'checked' : '' }} class="mr-2"> Disponible
                </label>
            </div>

            <div>
                <label class="block font-medium">Equipamiento</label>
                @php
                    $equipamientos = ['Proyector', 'Computadoras', 'Pizarra', 'Internet', 'Laboratorio'];
                    $selectedEquip = old('equipamiento', $espacio->equipamiento ?? []);
                @endphp
                <div class="space-x-2">
                    @foreach ($equipamientos as $item)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="equipamiento[]" value="{{ $item }}" class="mr-2"
                                {{ in_array($item, $selectedEquip) ? 'checked' : '' }}>
                            {{ $item }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Actualizar</button>
        </form>
    </div>
@endsection
