@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Espacios</h1>

        <a href="{{ route('espacios.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear
            Espacio</a>

        @if (session('success'))
            <div class="mt-4 bg-green-100 text-green-800 p-2 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full mt-4 table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-2 py-1">Nombre</th>
                    <th class="border px-2 py-1">Tipo</th>
                    <th class="border px-2 py-1">Modalidad</th>
                    <th class="border px-2 py-1">Capacidad</th>
                    <th class="border px-2 py-1">Disponible</th>
                    <th class="border px-2 py-1">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($espacios as $espacio)
                    <tr>
                        <td class="border px-2 py-1">{{ $espacio->nombre }}</td>
                        <td class="border px-2 py-1">{{ ucfirst($espacio->tipo) }}</td>
                        <td class="border px-2 py-1">{{ ucfirst($espacio->modalidad) }}</td>
                        <td class="border px-2 py-1">{{ $espacio->capacidad }}</td>
                        <td class="border px-2 py-1">{{ $espacio->disponible ? 'Sí' : 'No' }}</td>
                        <td class="border px-2 py-1 space-x-2">
                            <a href="{{ route('espacios.edit', $espacio) }}"
                                class="bg-yellow-400 px-2 py-1 rounded hover:bg-yellow-500">Editar</a>
                            <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 px-2 py-1 rounded hover:bg-red-600"
                                    onclick="return confirm('¿Seguro que desea eliminar este espacio?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $espacios->links() }}
        </div>
    </div>
@endsection
