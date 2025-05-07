<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentSlot extends Model
{
    protected $fillable = ['tournament_id', 'slot_date', 'start_time', 'end_time'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
