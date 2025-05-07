<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pair_unavailable_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pair_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tournament_slot_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pair_unavailable_slots');
    }
};
