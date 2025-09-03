@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Periodos Académicos</h1>
    <a href="{{ route('periodos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo Periodo</a>

    @if (session('success'))
        <div class="mt-4 bg-green-200 text-green-800 p-2 rounded">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full mt-4 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Nombre</th>
                <th class="border px-4 py-2">Fecha Inicio</th>
                <th class="border px-4 py-2">Fecha Fin</th>
                <th class="border px-4 py-2">Estado</th>
                <th class="border px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($periodos as $p)
                <tr>
                    <td class="border px-4 py-2">{{ $p->nombre }}</td>
                    <td class="border px-4 py-2">{{ $p->fecha_inicio }}</td>
                    <td class="border px-4 py-2">{{ $p->fecha_fin }}</td>
                    <td class="border px-4 py-2">{{ $p->estado }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('periodos.edit', $p) }}" class="text-blue-500">Editar</a>
                        <form action="{{ route('periodos.destroy', $p) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
