<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creación de la tabla 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->timestamp('email_verified_at')->nullable(); // Fecha de verificación del email
            $table->string('password'); // Contraseña cifrada
            $table->string('role')->default('user'); // Rol del usuario (por defecto 'user')
            $table->rememberToken(); // Token de "recordarme" para la sesión
            $table->timestamps(); // Timestamps para created_at y updated_at
        });

        // Creación de la tabla 'password_reset_tokens' para restablecer contraseñas
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Correo electrónico del usuario
            $table->string('token'); // Token de restablecimiento de contraseña
            $table->timestamp('created_at')->nullable(); // Fecha de creación del token
        });

        // Creación de la tabla 'sessions' para gestionar las sesiones activas
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID único para la sesión
            $table->foreignId('user_id')->nullable()->index(); // Relación con el usuario
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario
            $table->text('user_agent')->nullable(); // Agente de usuario (navegador, dispositivo)
            $table->longText('payload'); // Datos adicionales de la sesión
            $table->integer('last_activity')->index(); // Última actividad (timestamp)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminación de las tablas al revertir la migración
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
