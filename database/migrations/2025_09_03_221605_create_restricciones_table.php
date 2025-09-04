<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestriccionesTable extends Migration
{
    public function up()
    {
        Schema::create('restricciones', function (Blueprint $table) {
            $table->id();

            // Tipo de restricción: docente, aula, materia, estudiante
            $table->enum('tipo', ['docente', 'aula', 'materia', 'estudiante'])->default('docente');

            // Referencia según tipo
            $table->unsignedBigInteger('referencia_id'); // ID de docente, materia, aula o estudiante

            // Clave y valor de la restricción
            $table->string('clave'); // ej: 'horas_por_semana', 'no_dias', 'capacidad_max'
            $table->string('valor'); // valor correspondiente a la clave

            $table->timestamps();

            // Evitar duplicados
            $table->unique(['tipo', 'referencia_id', 'clave'], 'unique_restriccion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('restricciones');
    }
}
