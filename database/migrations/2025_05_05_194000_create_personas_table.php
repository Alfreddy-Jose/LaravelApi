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
        Schema::create('personas', function (Blueprint $table) {
            // Definicion de la tabla personas
            $table->id();
            $table->bigInteger('cedula_persona');
            $table->string('nombre');
            $table->string('apellido');
            $table->text('direccion');
            $table->string('municipio');
            $table->bigInteger('telefono');
            $table->string('email')->unique();
            $table->string('tipo_persona');
            $table->string('grado_inst');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
