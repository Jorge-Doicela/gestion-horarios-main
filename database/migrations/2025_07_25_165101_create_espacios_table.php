<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('nombre', 100);
            $table->enum('tipo', ['aula', 'laboratorio', 'auditorio', 'virtual', 'cancha', 'aula interactiva', 'otro'])->default('aula');
            $table->string('ubicacion', 255)->nullable();
            $table->boolean('disponible')->default(true);
            $table->enum('modalidad', ['presencial', 'virtual', 'hibrida'])->default('presencial');
            $table->integer('capacidad')->default(0);
            $table->json('equipamiento')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('espacios');
    }
};
