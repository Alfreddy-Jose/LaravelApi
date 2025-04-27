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
        Schema::create('lapso_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_lapso', 50);
            $table->bigInteger('ano');
            $table->string('tipo_lapso', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapso_academicos');
    }
};
