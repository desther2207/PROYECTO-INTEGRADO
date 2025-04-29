<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pair extends Model
{
    /** @use HasFactory<\Database\Factories\PairFactory> */
    use HasFactory;

    protected $fillable = ['player_1_id', 'player_2_id', 'tournament_id', 'invite_code', 'status', 'paid',];

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    //Al ser estas dos relaciones 2:N, la cosa cambia.
    
    public function playerOne():BelongsTo{
        return $this->belongsTo(User::class, 'player_1_id');
    }

    public function playerTwo():BelongsTo{
        return $this->belongsTo(User::class, 'player_2_id');
    }

    public function gamesAsFirstPair():HasMany{
        return $this->hasMany(Game::class, 'pair_one_id');
    }

    public function gamesAsSecondPair():HasMany{
        return $this->hasMany(Game::class, 'pair_two_id');
    }

    public function tournament():BelongsTo{
        return $this->belongsTo(Tournament::class);
    }
}
