@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Restricción</h1>

        <form method="POST" action="{{ route('restricciones.update', $restriccion->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo }}" {{ $restriccion->tipo == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Referencia</label>
                <select name="referencia_id" class="form-select" required>
                    <optgroup label="Docentes">
                        @foreach ($docentes as $d)
                            <option value="{{ $d->id }}"
                                {{ $restriccion->tipo == 'docente' && $restriccion->referencia_id == $d->id ? 'selected' : '' }}>
                                {{ $d->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Aulas">
                        @foreach ($aulas as $a)
                            <option value="{{ $a->id }}"
                                {{ $restriccion->tipo == 'aula' && $restriccion->referencia_id == $a->id ? 'selected' : '' }}>
                                {{ $a->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Materias">
                        @foreach ($materias as $m)
                            <option value="{{ $m->id }}"
                                {{ $restriccion->tipo == 'materia' && $restriccion->referencia_id == $m->id ? 'selected' : '' }}>
                                {{ $m->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Estudiantes">
                        @foreach ($estudiantes as $e)
                            <option value="{{ $e->id }}"
                                {{ $restriccion->tipo == 'estudiante' && $restriccion->referencia_id == $e->id ? 'selected' : '' }}>
                                {{ $e->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label>Clave</label>
                <input type="text" name="clave" class="form-control" value="{{ $restriccion->clave }}" required>
            </div>

            <div class="mb-3">
                <label>Valor</label>
                <input type="text" name="valor" class="form-control" value="{{ $restriccion->valor }}" required>
            </div>

            <button class="btn btn-success">Actualizar</button>
        </form>
    </div>
@endsection
