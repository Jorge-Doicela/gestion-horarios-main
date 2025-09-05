@extends('layouts.app')

@section('title', 'Generación Automática de Horarios')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 animate-fade-in-up">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Generación Automática de Horarios</h1>
                <p class="text-gray-600">Configure los parámetros y valide antes de generar</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl border border-white/20 p-6">
                <form method="POST" action="{{ route('horarios.generar') }}" id="generadorForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Período Académico *</label>
                            <select name="periodo_academico_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}">{{ $periodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Niveles (opcional)</label>
                            <select name="niveles[]" id="nivelesSelect" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                @foreach ($niveles ?? [] as $nivel)
                                    <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Si no selecciona, se considerarán todos</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Carreras (opcional)</label>
                            <select name="carreras[]" id="carrerasSelect" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                @foreach ($carreras ?? [] as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Si no selecciona, se considerarán todas</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Modalidades a considerar</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="inline-flex items-center space-x-2"><input type="checkbox"
                                        name="modalidades[]" value="presencial" checked><span>Presencial</span></label>
                                <label class="inline-flex items-center space-x-2"><input type="checkbox"
                                        name="modalidades[]" value="virtual" checked><span>Virtual</span></label>
                                <label class="inline-flex items-center space-x-2"><input type="checkbox"
                                        name="modalidades[]" value="hibrida" checked><span>Híbrida</span></label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Paralelos (opcional)</label>
                            <select name="paralelos[]" id="paralelosSelect" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                @foreach ($paralelos as $paralelo)
                                    <option value="{{ $paralelo->id }}" data-nivel="{{ $paralelo->nivel_id }}"
                                        data-carrera="{{ $paralelo->carrera_id }}">
                                        {{ $paralelo->nombre }}</option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Si no selecciona, se considerarán todos</small>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Docentes a incluir
                                (opcional)</label>
                            <select name="docentes[]" multiple
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                @foreach ($docentes as $docente)
                                    <option value="{{ $docente->id }}">{{ $docente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Rango de horas activo</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select name="hora_desde"
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                    @foreach ($horas as $hora)
                                        <option value="{{ $hora->id }}">{{ $hora->hora_inicio }}</option>
                                    @endforeach
                                </select>
                                <select name="hora_hasta"
                                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                    @foreach ($horas as $hora)
                                        <option value="{{ $hora->id }}">{{ $hora->hora_fin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Días a considerar</label>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach ($dias as $dia)
                                    <label class="inline-flex items-center space-x-2"><input type="checkbox" name="dias[]"
                                            value="{{ $dia->id }}" checked><span>{{ $dia->nombre }}</span></label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Reglas y Validaciones</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label
                                class="inline-flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                                <input type="checkbox" name="validar_conflictos" value="1" checked>
                                <span>Validar conflictos de docente, paralelo y espacio</span>
                            </label>
                            <label
                                class="inline-flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                                <input type="checkbox" name="respetar_restricciones" value="1" checked>
                                <span>Respetar restricciones definidas</span>
                            </label>
                            <label
                                class="inline-flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                                <input type="checkbox" name="balancear_carga" value="1" checked>
                                <span>Balancear carga horaria por docente</span>
                            </label>
                            <label
                                class="inline-flex items-center space-x-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3">
                                <input type="checkbox" name="priorizar_materias" value="1" checked>
                                <span>Priorizar materias críticas</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button type="button" onclick="simular()"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Simular Primero
                            </span>
                        </button>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-600 to-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-emerald-700 hover:to-green-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Generar Horarios
                            </span>
                        </button>
                        <a href="{{ route('horarios.index') }}"
                            class="flex-1 bg-white text-gray-700 px-6 py-3 rounded-xl font-semibold border-2 border-gray-300 hover:border-emerald-500 hover:text-emerald-600 transition-all duration-200 transform hover:scale-105 text-center">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Filtrar paralelos por niveles/carreras seleccionados
        (function() {
            const niveles = document.getElementById('nivelesSelect');
            const carreras = document.getElementById('carrerasSelect');
            const paralelos = document.getElementById('paralelosSelect');
            if (!paralelos) return;

            function filtrar() {
                const nivSel = niveles ? Array.from(niveles.options).filter(o => o.selected).map(o => o.value) : [];
                const carSel = carreras ? Array.from(carreras.options).filter(o => o.selected).map(o => o.value) : [];
                const options = paralelos.querySelectorAll('option');
                options.forEach(opt => {
                    const optNivel = opt.getAttribute('data-nivel');
                    const optCarrera = opt.getAttribute('data-carrera');
                    const visNivel = nivSel.length === 0 || nivSel.includes(optNivel);
                    const visCarr = carSel.length === 0 || carSel.includes(optCarrera);
                    const visible = visNivel && visCarr;
                    opt.style.display = visible ? '' : 'none';
                    if (!visible && opt.selected) opt.selected = false;
                });
            }
            if (niveles) niveles.addEventListener('change', filtrar);
            if (carreras) carreras.addEventListener('change', filtrar);
            filtrar();
        })();

        // Función para ejecutar simulación
        function simular() {
            const form = document.getElementById('generadorForm');
            const formData = new FormData(form);

            // Agregar el parámetro de simulación
            formData.append('simular', '1');

            // Cambiar la acción del formulario temporalmente
            const originalAction = form.action;
            form.action = originalAction;

            // Crear un input hidden para simular
            const simularInput = document.createElement('input');
            simularInput.type = 'hidden';
            simularInput.name = 'simular';
            simularInput.value = '1';
            form.appendChild(simularInput);

            // Enviar formulario
            form.submit();
        }
    </script>
@endsection
