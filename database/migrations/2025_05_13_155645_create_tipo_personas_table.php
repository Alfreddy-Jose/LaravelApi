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
        Schema::create('tipo_personas', function (Blueprint $table) {
            $table->id();
            $table->string('cedula_persona')->unique();
            $table->foreignId('persona_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('lapso_academico_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('pnf_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_personas');
    }
};
