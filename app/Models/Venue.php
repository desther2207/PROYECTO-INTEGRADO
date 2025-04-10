<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venue extends Model
{
    /** @use HasFactory<\Database\Factories\VenueFactory> */
    use HasFactory;

    protected $fillable = ['venue_name', 'num_courts'];

    public function courts():HasMany{
        return $this->hasMany(Court::class);
    }

    public function tournaments():BelongsToMany{
        return $this->belongsToMany(Tournament::class);
    }
}
