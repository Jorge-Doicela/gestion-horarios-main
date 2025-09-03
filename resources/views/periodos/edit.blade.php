@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar Periodo Académico</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('periodos.update', $periodo) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" class="border px-2 py-1 w-full" value="{{ old('nombre', $periodo->nombre) }}">
        </div>
        <div>
            <label>Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" class="border px-2 py-1 w-full"
                value="{{ old('fecha_inicio', $periodo->fecha_inicio) }}">
        </div>
        <div>
            <label>Fecha Fin:</label>
            <input type="date" name="fecha_fin" class="border px-2 py-1 w-full"
                value="{{ old('fecha_fin', $periodo->fecha_fin) }}">
        </div>
        <div>
            <label>Estado:</label>
            <select name="estado" class="border px-2 py-1 w-full">
                <option value="activo" {{ old('estado', $periodo->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ old('estado', $periodo->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo
                </option>
                <option value="finalizado" {{ old('estado', $periodo->estado) == 'finalizado' ? 'selected' : '' }}>Finalizado
                </option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('periodos.index') }}" class="ml-2 text-gray-700">Cancelar</a>
    </form>
@endsection
