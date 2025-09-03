@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Restricción</h1>

        <form method="POST" action="{{ route('restricciones.store') }}">
            @csrf

            <div class="mb-3">
                <label>Tipo</label>
                <select name="tipo" class="form-select" required>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Referencia</label>
                <select name="referencia_id" class="form-select" required>
                    <optgroup label="Docentes">
                        @foreach ($docentes as $d)
                            <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Aulas">
                        @foreach ($aulas as $a)
                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Materias">
                        @foreach ($materias as $m)
                            <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Estudiantes">
                        @foreach ($estudiantes as $e)
                            <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label>Clave</label>
                <input type="text" name="clave" class="form-control" value="{{ old('clave') }}" required>
            </div>

            <div class="mb-3">
                <label>Valor</label>
                <input type="text" name="valor" class="form-control" value="{{ old('valor') }}" required>
            </div>

            <button class="btn btn-success">Guardar</button>
        </form>
    </div>
@endsection
