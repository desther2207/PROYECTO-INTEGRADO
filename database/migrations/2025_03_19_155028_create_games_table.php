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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bracket_id')->constrained()->cascadeOnDelete();
            /*Relación 2:N con pairs*/
            $table->foreignId('pair_one_id')->constrained('pairs')->cascadeOnDelete();
            $table->foreignId('pair_two_id')->constrained('pairs')->cascadeOnDelete();
            /*Se añade un campo COURT(pista) en el que se indica la pista exacta donde se jugará el partido, a su vez esa pista pertenece a una sede */
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();

            $table->dateTime('start_game_date');
            $table->dateTime('end_game_date');
            /*TODO: ¿Cómo se manejarán los resultados? */
            $table->string('result');
            //$table->json('result');
            //TABLA EXTERNA game_result
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
