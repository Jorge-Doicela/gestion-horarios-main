<?php
// database/migrations/xxxx_xx_xx_create_docentes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocentesTable extends Migration
{
    public function up()
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('nombre', 100);
            $table->string('email', 100)->nullable()->unique();
            $table->string('titulo', 100)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->timestamps();
        });

        // Tabla pivote para asignación de materias
        Schema::create('docente_materia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['docente_id', 'materia_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('docente_materia');
        Schema::dropIfExists('docentes');
    }
}
