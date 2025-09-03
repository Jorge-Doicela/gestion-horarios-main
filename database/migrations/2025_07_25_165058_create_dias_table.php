<?php

// database/migrations/xxxx_xx_xx_create_dias_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiasTable extends Migration
{
    public function up()
    {
        Schema::create('dias', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('nombre', 20); // Ej: Lunes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dias');
    }
}
