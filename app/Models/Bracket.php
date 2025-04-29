<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bracket extends Model
{
    /** @use HasFactory<\Database\Factories\BracketFactory> */
    use HasFactory;

    protected $fillable = ['tournament_id', 'category_id', 'status', 'type'];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function getPairsFromBracket(Bracket $bracket)
    {
        return $bracket->category->pairs()
            ->where('tournament_id', $bracket->tournament_id)
            ->inRandomOrder()
            ->get();
    }
}
