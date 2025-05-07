<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PairUnavailableSlot extends Model
{
    protected $fillable = ['pair_id', 'tournament_slot_id'];

    public function pair()
    {
        return $this->belongsTo(Pair::class);
    }

    public function tournamentSlot()
    {
        return $this->belongsTo(TournamentSlot::class);
    }
}

