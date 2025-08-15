<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbandonedCart extends Model
{
    /** @use HasFactory<\Database\Factories\AbandonedCartFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'email',
        'cart_data',
        'total_amount',
        'currency',
        'abandoned_at',
        'reminder_sent_at',
        'recovered_at',
        'recovery_token',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'total_amount' => 'decimal:2',
        'abandoned_at' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'recovered_at' => 'datetime',
    ];

    /**
     * Get the user that owns the abandoned cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
