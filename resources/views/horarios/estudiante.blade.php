{{-- resources/views/horarios/estudiante.blade.php --}}
@extends('layouts.app')

@section('title', 'Horario Semanal - Estudiante')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Horario Semanal - Estudiante</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($error)
            <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
                {{ $error }}
            </div>
        @else
            {{-- Botones de exportación --}}
            <div class="mb-4 flex gap-2">
                <a href="{{ route('horario.estudiante.pdf') }}" target="_blank"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Exportar PDF</a>
                <a href="{{ route('horario.estudiante.excel') }}"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Exportar Excel</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-2">Hora / Día</th>
                            @foreach ($dias as $dia)
                                <th class="border p-2">{{ $dia->nombre }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horas as $hora)
                            <tr class="hover:bg-gray-50">
                                <td class="border p-2 font-semibold text-sm">
                                    {{ \Carbon\Carbon::parse($hora->hora_inicio)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($hora->hora_fin)->format('H:i') }}
                                </td>

                                @foreach ($dias as $dia)
                                    @php
                                        $clase = $horarios->first(function ($h) use ($hora, $dia) {
                                            return $h->hora_id == $hora->id && $h->dia_id == $dia->id;
                                        });
                                    @endphp

                                    <td class="border p-2 text-xs align-top">
                                        @if ($clase)
                                            @php
                                                $bg = match ($clase->modalidad) {
                                                    'presencial' => 'bg-green-200',
                                                    'virtual' => 'bg-blue-200',
                                                    'hibrida' => 'bg-yellow-200',
                                                    default => 'bg-gray-200',
                                                };
                                            @endphp
                                            <div class="{{ $bg }} p-1 rounded text-center">
                                                {{ $clase->materia->nombre }} <br>
                                                {{ $clase->docente->nombre }} <br>
                                                {{ $clase->espacio?->nombre ?? 'Sin asignar' }}
                                            </div>
                                        @else
                                            <div class="text-gray-400 text-center">-</div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
