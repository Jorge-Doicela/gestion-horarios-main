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

            // Tipo de restricción: docente, paralelo o espacio
            $table->enum('tipo', ['docente', 'paralelo', 'espacio'])->default('docente');

            // Referencia según tipo
            $table->unsignedBigInteger('referencia_id'); // ID de docente, paralelo o espacio

            $table->foreignId('dia_id')->nullable()->constrained('dias')->onDelete('cascade'); // Día restringido
            $table->foreignId('hora_id')->nullable()->constrained('horas')->onDelete('cascade'); // Hora restringida

            $table->text('comentarios')->nullable(); // Notas sobre la restricción
            $table->timestamps();

            $table->unique(['tipo', 'referencia_id', 'dia_id', 'hora_id'], 'unique_restriccion'); // Evitar duplicados
        });
    }

    public function down()
    {
        Schema::dropIfExists('restricciones');
    }
}
