@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Calendario de Horarios</h1>

        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <form action="{{ route('horarios.generar') }}" method="POST" class="mb-4 flex items-center gap-2">
            @csrf
            <label for="periodo_id" class="font-semibold">Periodo académico:</label>
            <select name="periodo_id" id="periodo_id" class="border px-2 py-1 rounded">
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ $periodo_id == $periodo->id ? 'selected' : '' }}>
                        {{ $periodo->nombre }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Generar horarios
                automáticamente</button>
        </form>

        <div id="calendar"></div>

        <h2 class="text-xl font-bold mt-6 mb-2">Conflictos detectados</h2>
        @if ($conflictos->isEmpty())
            <p>No hay conflictos.</p>
        @else
            <ul class="list-disc pl-5">
                @foreach ($conflictos as $conflicto)
                    <li>{{ $conflicto->motivo }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

@section('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var events = [
                @foreach ($horarios as $h)
                    {
                        title: '{{ $h->materia->nombre }} - {{ $h->docente->nombre }}',
                        start: '{{ $h->dia->nombre }}T{{ \Carbon\Carbon::parse($h->hora->hora_inicio)->format('H:i:s') }}',
                        end: '{{ $h->dia->nombre }}T{{ \Carbon\Carbon::parse($h->hora->hora_fin)->format('H:i:s') }}',
                        extendedProps: {
                            espacio: '{{ $h->espacio->nombre ?? '-' }}',
                            paralelo: '{{ $h->paralelo->nombre }}',
                            modalidad: '{{ $h->modalidad }}'
                        }
                    },
                @endforeach
            ];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                slotMinTime: "07:00:00",
                slotMaxTime: "22:00:00",
                allDaySlot: false,
                events: events,
                eventClick: function(info) {
                    alert(
                        'Materia: ' + info.event.title +
                        '\nParalelo: ' + info.event.extendedProps.paralelo +
                        '\nEspacio: ' + info.event.extendedProps.espacio +
                        '\nModalidad: ' + info.event.extendedProps.modalidad
                    );
                },
                dayHeaderFormat: {
                    weekday: 'long'
                }
            });

            calendar.render();
        });
    </script>
@endsection
