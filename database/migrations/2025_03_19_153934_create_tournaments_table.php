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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('tournament_image')->nullable();
            $table->string('cartel');
            $table->string('tournament_name');
            $table->string('description');
            $table->decimal('incription_price', 5, 2);
            $table->enum('level', ['primera', 'segunda', 'tercera', 'cuarta']);
            $table->enum('status', ['inscripcion', 'en curso', 'finalizado']);
            $table->date('inscription_start_date')->nullable(); //Fecha de inicio de inscripción
            $table->date('inscription_end_date')->nullable(); //Fecha de fin de inscripción
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_pairs'); //Numero de parejas máximas que tendrá el torneo.
            $table->integer('current_pairs')->default(0); //Número de parejas actual del torneo(empezará siempre en cero)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
