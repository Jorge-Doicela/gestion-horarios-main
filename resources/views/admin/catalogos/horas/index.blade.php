@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Catálogo: Horas</h1>
                <a href="{{ route('admin.horas.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Nuevo</a>
            </div>
            @if (session('success'))
                <div class="mb-4 text-green-700">{{ session('success') }}</div>
            @endif
            <div class="bg-white rounded-xl shadow p-4">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-600">
                            <th class="py-2">ID</th>
                            <th class="py-2">Inicio</th>
                            <th class="py-2">Fin</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horas as $hora)
                            <tr class="border-t">
                                <td class="py-2">{{ $hora->id }}</td>
                                <td class="py-2">{{ $hora->hora_inicio }}</td>
                                <td class="py-2">{{ $hora->hora_fin }}</td>
                                <td class="py-2">
                                    <a href="{{ route('admin.horas.edit', $hora) }}" class="text-indigo-600">Editar</a>
                                    <form action="{{ route('admin.horas.destroy', $hora) }}" method="POST" class="inline"
                                        onsubmit="return confirm('¿Eliminar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-3">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">{{ $horas->links() }}</div>
            </div>
        </div>
    </div>
@endsection
