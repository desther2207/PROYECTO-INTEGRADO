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
        Schema::create('pair_unavailabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pair_id')->constrained()->onDelete('cascade');
            $table->dateTime('start_unavailable');
            $table->dateTime('end_unavailable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pair_unavailabilities');
    }
};
