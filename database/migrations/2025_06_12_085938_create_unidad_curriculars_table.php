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
        Schema::create('unidad_curriculars', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->text('descripcion', 255);
            $table->integer('unidad_credito');
            $table->integer('hora_acad');
            $table->integer('hora_total_est');
            $table->string('periodo', 50); 
            // Llave foranea de trimestre
            $table->foreignId('trimestre_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_curriculars');
    }
};
