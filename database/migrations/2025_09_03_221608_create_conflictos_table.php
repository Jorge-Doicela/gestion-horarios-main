<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConflictosTable extends Migration
{
    public function up()
    {
        Schema::create('conflictos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_id')->nullable()->constrained('horarios')->onDelete('cascade');
            $table->enum('tipo', ['docente', 'paralelo', 'espacio', 'generacion'])->default('docente');
            $table->text('motivo'); // Detalle del conflicto
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conflictos');
    }
}
