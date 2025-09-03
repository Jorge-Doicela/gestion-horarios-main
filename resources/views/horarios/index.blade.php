@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Horarios Académicos</h1>

        <a href="{{ route('horarios.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Crear Horario</a>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b">Paralelo</th>
                    <th class="py-2 px-4 border-b">Materia</th>
                    <th class="py-2 px-4 border-b">Docente</th>
                    <th class="py-2 px-4 border-b">Espacio</th>
                    <th class="py-2 px-4 border-b">Día</th>
                    <th class="py-2 px-4 border-b">Hora</th>
                    <th class="py-2 px-4 border-b">Periodo</th>
                    <th class="py-2 px-4 border-b">Modalidad</th>
                    <th class="py-2 px-4 border-b">Estado</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios as $horario)
                    @php
                        $estadoColor = match ($horario->estado) {
                            'activo' => 'bg-green-200 text-green-800',
                            'suspendido' => 'bg-yellow-200 text-yellow-800',
                            'finalizado' => 'bg-gray-200 text-gray-800',
                            default => 'bg-white',
                        };
                        $editarDisabled = $horario->estado !== 'activo';
                        $eliminarDisabled = $horario->estado === 'finalizado';
                    @endphp
                    <tr class="text-center">
                        <td class="py-2 px-4 border-b">{{ $horario->paralelo->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $horario->materia->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $horario->docente->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $horario->espacio->nombre ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $horario->dia->nombre }}</td>
                        <td class="py-2 px-4 border-b">{{ $horario->hora->hora_inicio }} - {{ $horario->hora->hora_fin }}
                        </td>
                        <td class="py-2 px-4 border-b">{{ $horario->periodo->nombre }}</td>
                        <td class="py-2 px-4 border-b capitalize">{{ $horario->modalidad }}</td>
                        <td class="py-2 px-4 border-b {{ $estadoColor }} capitalize">{{ $horario->estado }}</td>
                        <td class="py-2 px-4 border-b flex justify-center gap-2">
                            <a href="{{ route('horarios.edit', $horario->id) }}"
                                class="px-2 py-1 rounded {{ $editarDisabled ? 'bg-gray-400 cursor-not-allowed' : 'bg-yellow-400 hover:bg-yellow-500' }}"
                                {{ $editarDisabled ? 'onclick=return false;' : '' }}>Editar</a>
                            <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar horario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 rounded {{ $eliminarDisabled ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600 text-white' }}"
                                    {{ $eliminarDisabled ? 'disabled' : '' }}>Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="py-4">No hay horarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
