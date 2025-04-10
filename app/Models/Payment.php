<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tournament_id',
        'payment_date',
        'amount',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function tournaments():BelongsTo{
        return $this->belongsTo(Tournament::class);
    }
}
