@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Crear Horario</h1>

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('horarios.store') }}" method="POST" class="space-y-4 bg-white p-4 rounded shadow">
            @csrf

            <div>
                <label class="block">Paralelo</label>
                <select name="paralelo_id" class="border rounded w-full p-2">
                    @foreach ($paralelos as $paralelo)
                        <option value="{{ $paralelo->id }}">{{ $paralelo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Materia</label>
                <select name="materia_id" class="border rounded w-full p-2">
                    @foreach ($materias as $materia)
                        <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Docente</label>
                <select name="docente_id" class="border rounded w-full p-2">
                    @foreach ($docentes as $docente)
                        <option value="{{ $docente->id }}">{{ $docente->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Espacio</label>
                <select name="espacio_id" class="border rounded w-full p-2">
                    <option value="">-- Ninguno --</option>
                    @foreach ($espacios as $espacio)
                        <option value="{{ $espacio->id }}">{{ $espacio->nombre }} ({{ $espacio->tipo }})</option>
                    @endforeach
                </select>
                <small class="text-gray-500">Requerido si la modalidad es presencial o híbrida.</small>
            </div>

            <div>
                <label>Día</label>
                <select name="dia_id" class="border rounded w-full p-2">
                    @foreach ($dias as $dia)
                        <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Hora</label>
                <select name="hora_id" class="border rounded w-full p-2">
                    @foreach ($horas as $hora)
                        <option value="{{ $hora->id }}">{{ $hora->hora_inicio }} - {{ $hora->hora_fin }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Periodo Académico</label>
                <select name="periodo_academico_id" class="border rounded w-full p-2">
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Fecha Inicio</label>
                <input type="date" name="fecha_inicio" class="border rounded w-full p-2">
            </div>

            <div>
                <label>Fecha Fin</label>
                <input type="date" name="fecha_fin" class="border rounded w-full p-2">
            </div>

            <div>
                <label>Modalidad</label>
                <select name="modalidad" class="border rounded w-full p-2">
                    <option value="presencial">Presencial</option>
                    <option value="virtual">Virtual</option>
                    <option value="hibrida">Híbrida</option>
                </select>
            </div>

            <div>
                <label>Estado</label>
                <select name="estado" class="border rounded w-full p-2">
                    <option value="activo">Activo</option>
                    <option value="suspendido">Suspendido</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>

            <div>
                <label>Observaciones</label>
                <textarea name="observaciones" class="border rounded w-full p-2"></textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
                <a href="{{ route('horarios.index') }}"
                    class="ml-2 bg-gray-400 px-4 py-2 rounded hover:bg-gray-500 text-white">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
