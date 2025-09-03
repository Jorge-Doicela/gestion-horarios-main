@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Restricciones</h1>
        <a href="{{ route('restricciones.create') }}" class="btn btn-primary mb-3">Crear Nueva</a>

        <form method="GET" action="{{ route('restricciones.index') }}" class="mb-3">
            <select name="tipo" onchange="this.form.submit()" class="form-select w-auto">
                <option value="">Todos</option>
                <option value="docente" {{ request('tipo') == 'docente' ? 'selected' : '' }}>Docente</option>
                <option value="aula" {{ request('tipo') == 'aula' ? 'selected' : '' }}>Aula</option>
                <option value="materia" {{ request('tipo') == 'materia' ? 'selected' : '' }}>Materia</option>
                <option value="estudiante" {{ request('tipo') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
            </select>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Referencia</th>
                    <th>Clave</th>
                    <th>Valor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restricciones as $r)
                    <tr>
                        <td>{{ $r->tipo }}</td>
                        <td>{{ $r->referencia ? $r->referencia->nombre ?? ($r->referencia->email ?? 'N/A') : 'N/A' }}</td>
                        <td>{{ $r->clave }}</td>
                        <td>{{ $r->valor }}</td>
                        <td>
                            <a href="{{ route('restricciones.edit', $r->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('restricciones.destroy', $r->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Eliminar esta restricción?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $restricciones->links() }}
    </div>
@endsection
