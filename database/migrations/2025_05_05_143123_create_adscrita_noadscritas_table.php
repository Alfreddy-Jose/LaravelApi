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
        Schema::create('adscrita_noadscritas', function (Blueprint $table) {
            $table->id();
            // Relacion con PNF
            $table->foreignId('pnf_id')
                ->constrained('pnfs')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adscrita_noadscritas');
    }
};
