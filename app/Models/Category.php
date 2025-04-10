<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'category_color',
    ];

    public function tournaments():BelongsToMany{
        return $this->belongsToMany(Tournament::class);
    }

    public function pairs():BelongsToMany{
        return $this->belongsToMany(Pair::class);
    }
}
