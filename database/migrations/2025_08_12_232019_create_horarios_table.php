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
        Schema::create('clases', function (Blueprint $table) {
            // Identificador único
            $table->id();

            // Relaciones con otras tablas
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            $table->foreignId('pnf_id')->constrained('pnfs')->onDelete('cascade');
            $table->foreignId('trayecto_id')->constrained('trayectos')->onDelete('cascade');
            $table->foreignId('trimestre_id')->constrained('trimestres')->onDelete('cascade');
            $table->foreignId('unidad_curricular_id')->constrained('unidad_curriculars')->onDelete('cascade');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
            $table->foreignId('espacio_id')->constrained('espacios')->onDelete('cascade');
            $table->foreignId('bloque_id')->constrained('bloques_turnos')->onDelete('cascade');

            // Datos del evento
            $table->string('dia', 10); // Ej: 'LUNES'
            $table->integer('duracion'); // Duración en bloques (1 bloque = 1 hora)

            // Timestamps automáticos
            $table->timestamps();

            // Restricción única para evitar duplicados
            $table->unique([
                'espacio_id',
                'dia',
                'bloque_id'
            ], 'horario_unique_espacio_dia_bloque');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
