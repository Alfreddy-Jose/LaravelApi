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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 50);
            // Relacion con persona
            $table->foreignId('persona_id')
                ->constrained()
                ->onDelete('cascade');
            // Relacion con PNF
            $table->string('pnf_id');
            $table->foreign('pnf_id')
                ->references('id')
                ->on('pnfs')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
