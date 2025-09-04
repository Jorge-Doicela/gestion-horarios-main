@php
    $horariosPorDocente = $horarios->groupBy('docente_id');
@endphp

@if ($horarios->count() > 0)
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($horariosPorDocente as $docenteId => $horariosDocente)
                @php
                    $docente = $horariosDocente->first()->docente;
                    $totalHorarios = $horariosDocente->count();
                    $horariosActivos = $horariosDocente->where('estado', 'activo')->count();
                    $horariosPresenciales = $horariosDocente->where('modalidad', 'presencial')->count();
                    $horariosVirtuales = $horariosDocente->where('modalidad', 'virtual')->count();
                @endphp

                <div
                    class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Header del Docente -->
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white">{{ $docente->nombre }}</h3>
                                <p class="text-green-100 text-sm">{{ $totalHorarios }} horarios • {{ $horariosActivos }}
                                    activos</p>
                            </div>
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas del Docente -->
                    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $horariosPresenciales }} presencial
                                </span>
                                <span class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $horariosVirtuales }} virtual
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contenido del Docente -->
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($horariosDocente->groupBy('dia_id') as $diaId => $horariosDia)
                                @php
                                    $dia = $horariosDia->first()->dia;
                                @endphp

                                <div class="border-l-4 border-green-200 pl-4">
                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $dia->nombre }}
                                    </h4>

                                    <div class="space-y-3">
                                        @foreach ($horariosDia->sortBy('hora.hora_inicio') as $horario)
                                            @php
                                                $estadoColor = match ($horario->estado) {
                                                    'activo' => 'bg-green-100 text-green-800 border-green-200',
                                                    'suspendido' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'finalizado' => 'bg-red-100 text-red-800 border-red-200',
                                                    default => 'bg-gray-100 text-gray-800 border-gray-200',
                                                };
                                            @endphp

                                            <div
                                                class="bg-gray-50 rounded-lg p-3 border border-gray-200 hover:bg-gray-100 transition-colors duration-200">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="text-sm font-medium text-gray-900">{{ $horario->materia->nombre }}</span>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $estadoColor }}">
                                                            {{ ucfirst($horario->estado) }}
                                                        </span>
                                                    </div>
                                                    <span
                                                        class="text-sm text-gray-600">{{ $horario->hora->hora_inicio }}
                                                        - {{ $horario->hora->hora_fin }}</span>
                                                </div>

                                                <div class="flex items-center justify-between text-sm text-gray-600">
                                                    <div class="flex items-center space-x-4">
                                                        <span class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                                </path>
                                                            </svg>
                                                            {{ $horario->paralelo->nombre }}
                                                        </span>
                                                        @if ($horario->espacio)
                                                            <span class="flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                                    </path>
                                                                </svg>
                                                                {{ $horario->espacio->nombre }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center space-x-2">
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                            {{ $horario->modalidad == 'presencial' ? 'bg-green-100 text-green-800' : ($horario->modalidad == 'virtual' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800') }}">
                                                            {{ ucfirst($horario->modalidad) }}
                                                        </span>

                                                        <div class="flex space-x-1">
                                                            <a href="{{ route('horarios.edit', $horario->id) }}"
                                                                class="text-cyan-600 hover:text-cyan-900 transition-colors duration-200">
                                                                <svg class="w-3 h-3" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    @if ($horarios->hasPages())
        <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando {{ $horarios->firstItem() }} a {{ $horarios->lastItem() }} de {{ $horarios->total() }}
                    resultados
                </div>
                <div class="flex items-center space-x-2">
                    {{ $horarios->links() }}
                </div>
            </div>
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="text-center py-12">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay horarios registrados</h3>
        <p class="text-gray-600 mb-6">Comience creando su primer horario académico.</p>
        <a href="{{ route('horarios.create') }}"
            class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
            <span class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Crear Primer Horario
            </span>
        </a>
    </div>
@endif
