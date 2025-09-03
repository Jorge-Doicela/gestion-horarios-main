@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Editar Horario</h1>

        @if ($horario->estado !== 'activo')
            <div class="bg-yellow-200 text-yellow-800 p-2 mb-4 rounded">
                Este horario está <strong>{{ $horario->estado }}</strong> y no puede ser modificado.
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-2 mb-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('horarios.update', $horario->id) }}" method="POST"
            class="space-y-4 bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')

            @php $disabled = $horario->estado !== 'activo' ? 'disabled' : ''; @endphp

            <div>
                <label>Paralelo</label>
                <select name="paralelo_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($paralelos as $paralelo)
                        <option value="{{ $paralelo->id }}" {{ $horario->paralelo_id == $paralelo->id ? 'selected' : '' }}>
                            {{ $paralelo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Materia</label>
                <select name="materia_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($materias as $materia)
                        <option value="{{ $materia->id }}" {{ $horario->materia_id == $materia->id ? 'selected' : '' }}>
                            {{ $materia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Docente</label>
                <select name="docente_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($docentes as $docente)
                        <option value="{{ $docente->id }}" {{ $horario->docente_id == $docente->id ? 'selected' : '' }}>
                            {{ $docente->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Espacio</label>
                <select name="espacio_id" class="border rounded w-full p-2" {{ $disabled }}>
                    <option value="">-- Ninguno --</option>
                    @foreach ($espacios as $espacio)
                        <option value="{{ $espacio->id }}" {{ $horario->espacio_id == $espacio->id ? 'selected' : '' }}>
                            {{ $espacio->nombre }} ({{ $espacio->tipo }})
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Requerido si la modalidad es presencial o híbrida.</small>
            </div>

            <div>
                <label>Día</label>
                <select name="dia_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($dias as $dia)
                        <option value="{{ $dia->id }}" {{ $horario->dia_id == $dia->id ? 'selected' : '' }}>
                            {{ $dia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Hora</label>
                <select name="hora_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($horas as $hora)
                        <option value="{{ $hora->id }}" {{ $horario->hora_id == $hora->id ? 'selected' : '' }}>
                            {{ $hora->hora_inicio }} - {{ $hora->hora_fin }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Periodo Académico</label>
                <select name="periodo_academico_id" class="border rounded w-full p-2" {{ $disabled }}>
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo->id }}"
                            {{ $horario->periodo_academico_id == $periodo->id ? 'selected' : '' }}>
                            {{ $periodo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ $horario->fecha_inicio }}"
                    class="border rounded w-full p-2" {{ $disabled }}>
            </div>

            <div>
                <label>Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ $horario->fecha_fin }}" class="border rounded w-full p-2"
                    {{ $disabled }}>
            </div>

            <div>
                <label>Modalidad</label>
                <select name="modalidad" class="border rounded w-full p-2" {{ $disabled }}>
                    <option value="presencial" {{ $horario->modalidad == 'presencial' ? 'selected' : '' }}>Presencial
                    </option>
                    <option value="virtual" {{ $horario->modalidad == 'virtual' ? 'selected' : '' }}>Virtual</option>
                    <option value="hibrida" {{ $horario->modalidad == 'hibrida' ? 'selected' : '' }}>Híbrida</option>
                </select>
            </div>

            <div>
                <label>Estado</label>
                <select name="estado" class="border rounded w-full p-2" {{ $disabled }}>
                    <option value="activo" {{ $horario->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="suspendido" {{ $horario->estado == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                    <option value="finalizado" {{ $horario->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>
            </div>

            <div>
                <label>Observaciones</label>
                <textarea name="observaciones" class="border rounded w-full p-2" {{ $disabled }}>{{ $horario->observaciones }}</textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    {{ $disabled }}>Actualizar</button>
                <a href="{{ route('horarios.index') }}"
                    class="ml-2 bg-gray-400 px-4 py-2 rounded hover:bg-gray-500 text-white">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
