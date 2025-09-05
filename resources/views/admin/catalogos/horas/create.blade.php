@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8">
        <div class="max-w-xl mx-auto bg-white rounded-xl shadow p-6">
            <h1 class="text-xl font-bold mb-4">Nueva Franja Horaria</h1>
            <form method="POST" action="{{ route('admin.horas.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hora inicio (HH:MM)</label>
                        <input name="hora_inicio" value="{{ old('hora_inicio') }}" required placeholder="08:00"
                            class="w-full border rounded px-3 py-2">
                        @error('hora_inicio')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Hora fin (HH:MM)</label>
                        <input name="hora_fin" value="{{ old('hora_fin') }}" required placeholder="09:30"
                            class="w-full border rounded px-3 py-2">
                        @error('hora_fin')
                            <div class="text-red-600 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.horas.index') }}"
                        class="flex-1 border rounded px-4 py-2 text-center">Cancelar</a>
                    <button class="flex-1 bg-indigo-600 text-white rounded px-4 py-2">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
