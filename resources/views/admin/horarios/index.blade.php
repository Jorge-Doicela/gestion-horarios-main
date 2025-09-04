@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Gestión de Horarios</h1>

        <div class="mb-6">
            <label for="periodo_id" class="block mb-2 font-semibold">Selecciona Periodo Académico</label>
            <select id="periodo_id" class="border p-2 rounded w-64">
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                @endforeach
            </select>
            <button id="generarBtn" class="bg-blue-600 text-white px-4 py-2 rounded ml-2">Generar Horarios</button>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Horarios Generados</h2>
            <div id="calendario"></div>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Conflictos</h2>
            <ul id="conflictosList" class="list-disc pl-6 text-red-600"></ul>
        </div>
    </div>
@endsection

@section('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let calendarioEl = document.getElementById('calendario');
            let calendario = new FullCalendar.Calendar(calendarioEl, {
                initialView: 'timeGridWeek',
                slotMinTime: "07:00:00",
                slotMaxTime: "21:00:00",
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: []
            });
            calendario.render();

            document.getElementById('generarBtn').addEventListener('click', function() {
                let periodo_id = document.getElementById('periodo_id').value;

                fetch('/api/generar-horarios', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            periodo_id: periodo_id
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'ok') {
                            cargarHorarios(periodo_id);
                            cargarConflictos(periodo_id);
                            alert(
                                `Horarios generados: ${data.horarios_generados}, Conflictos: ${data.conflictos}`);
                        } else {
                            alert('Error: ' + data.mensaje);
                        }
                    });
            });

            function cargarHorarios(periodo_id) {
                fetch(`/api/horarios?periodo_id=${periodo_id}`)
                    .then(res => res.json())
                    .then(data => {
                        calendario.removeAllEvents();
                        data.horarios.forEach(h => {
                            calendario.addEvent({
                                title: `${h.materia.nombre} - ${h.docente.nombre}`,
                                start: `${h.dia.nombre}T${h.hora_inicio}`,
                                end: `${h.dia.nombre}T${h.hora_fin}`
                            });
                        });
                    });
            }

            function cargarConflictos(periodo_id) {
                fetch(`/api/conflictos?periodo_id=${periodo_id}`)
                    .then(res => res.json())
                    .then(data => {
                        let lista = document.getElementById('conflictosList');
                        lista.innerHTML = '';
                        data.conflictos.forEach(c => {
                            let li = document.createElement('li');
                            li.textContent = c.motivo;
                            lista.appendChild(li);
                        });
                    });
            }
        });
    </script>
@endsection
