@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Espacio</h1>

        <form action="{{ route('espacios.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="border rounded px-2 py-1 w-full">
                @error('nombre')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Tipo</label>
                <select name="tipo" class="border rounded px-2 py-1 w-full">
                    @foreach (['aula', 'laboratorio', 'cancha', 'aula interactiva', 'otro'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
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
                        <option value="{{ $modalidad }}" {{ old('modalidad') == $modalidad ? 'selected' : '' }}>
                            {{ ucfirst($modalidad) }}</option>
                    @endforeach
                </select>
                @error('modalidad')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Capacidad</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', 0) }}"
                    class="border rounded px-2 py-1 w-full">
                @error('capacidad')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Ubicación</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion') }}"
                    class="border rounded px-2 py-1 w-full">
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="disponible" value="1" {{ old('disponible', true) ? 'checked' : '' }}
                        class="mr-2"> Disponible
                </label>
            </div>

            <div>
                <label class="block font-medium">Equipamiento</label>
                @php $equipamientos = ['Proyector','Computadoras','Pizarra','Internet','Laboratorio']; @endphp
                <div class="space-x-2">
                    @foreach ($equipamientos as $item)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="equipamiento[]" value="{{ $item }}" class="mr-2"
                                {{ is_array(old('equipamiento')) && in_array($item, old('equipamiento')) ? 'checked' : '' }}>
                            {{ $item }}
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear</button>
        </form>
    </div>
@endsection
