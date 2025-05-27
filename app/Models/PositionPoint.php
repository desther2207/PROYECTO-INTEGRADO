<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionPoint extends Model
{
    protected $fillable = ['category', 'type', 'position', 'base_points'];
}