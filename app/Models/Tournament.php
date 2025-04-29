<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    /** @use HasFactory<\Database\Factories\TournamentFactory> */
    use HasFactory;

    protected $fillable = [
        'tournament_image',
        'cartel',
        'tournament_name',
        'description',
        'incription_price',
        'province_id',
        'status',
        'inscription_start_date', // Fecha de inicio de inscripción
        'inscription_end_date',   // Fecha de fin de inscripción
        'start_date',
        'end_date',
        'max_pairs', // Máximo de parejas
        'current_pairs',       // Número actual de parejas
    ];

    public function organizers():BelongsToMany{
        return $this->belongsToMany(User::class);
    }

    public function pairs():HasMany{
        return $this->hasMany(Pair::class);
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class);
    }

    public function venues():BelongsToMany{
        return $this->belongsToMany(Venue::class);
    }

    public function brackets():HasMany{
        return $this->hasMany(Bracket::class);
    }

    public function payments():HasMany{
        return $this->hasMany(Payment::class);
    }

    public function province():BelongsTo{
        return $this->belongsTo(Province::class);
    }
}
