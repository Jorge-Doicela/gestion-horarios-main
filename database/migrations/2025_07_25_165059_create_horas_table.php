<?php

// database/migrations/xxxx_xx_xx_create_horas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorasTable extends Migration
{
    public function up()
    {
        Schema::create('horas', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horas');
    }
}
