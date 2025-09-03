<?php

// database/migrations/xxxx_xx_xx_create_carreras_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarrerasTable extends Migration
{
    public function up()
    {
        Schema::create('carreras', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('nombre', 100);
            $table->string('codigo', 20)->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carreras');
    }
}
