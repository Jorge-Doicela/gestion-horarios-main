<?php

// database/migrations/xxxx_xx_xx_create_niveles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelesTable extends Migration
{
    public function up()
    {
        Schema::create('niveles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50); // Ej: "1er Semestre"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('niveles');
    }
}
