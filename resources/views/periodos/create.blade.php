@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear Periodo Académico</h1>

    @if ($errors->any())
        <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('periodos.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label>Nombre:</label>
            <input type="text" name="nombre" class="border px-2 py-1 w-full" value="{{ old('nombre') }}">
        </div>
        <div>
            <label>Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" class="border px-2 py-1 w-full" value="{{ old('fecha_inicio') }}">
        </div>
        <div>
            <label>Fecha Fin:</label>
            <input type="date" name="fecha_fin" class="border px-2 py-1 w-full" value="{{ old('fecha_fin') }}">
        </div>
        <div>
            <label>Estado:</label>
            <select name="estado" class="border px-2 py-1 w-full">
                <option value="activo">Activo</option>
                <option value="inactivo">Inactivo</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('periodos.index') }}" class="ml-2 text-gray-700">Cancelar</a>
    </form>
@endsection
