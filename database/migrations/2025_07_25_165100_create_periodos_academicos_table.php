<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodos_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activo', 'inactivo', 'finalizado'])->default('activo');
            $table->timestamps();

            // índice para búsquedas rápidas
            $table->index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodos_academicos');
    }
};
