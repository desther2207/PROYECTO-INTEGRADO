<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $fillable = ['game_number', 'round_number','bracket_id', 'pair_one_id', 'pair_two_id', 'court_id', 'venue_id', 'start_game_date', 'end_game_date', 'result'];

    public function bracket():BelongsTo{
        return $this->belongsTo(Bracket::class);
    }

    public function pairOne():BelongsTo{
        return $this->belongsTo(Pair::class, 'pair_one_id');
    }

    public function pairTwo():BelongsTo{
        return $this->belongsTo(Pair::class, 'pair_two_id');
    }

    public function venue():BelongsTo{
        return $this->belongsTo(Venue::class);
    }

    public function court():BelongsTo{
        return $this->belongsTo(Court::class);
    }
}
