<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'province_name',
        'color',
    ];

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function venues()
    {
        return $this->hasMany(Venue::class);
    }
}
