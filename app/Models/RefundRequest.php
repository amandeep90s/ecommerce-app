<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundRequest extends Model
{
    /** @use HasFactory<\Database\Factories\RefundRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'description',
        'refund_amount',
        'status',
        'admin_notes',
        'processed_at',
        'processed_by',
        'refund_method',
        'transaction_id',
    ];

    protected $casts = [
        'refund_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the order that the refund request belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that made the refund request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin user that processed the refund.
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope a query to only include pending refund requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved refund requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected refund requests.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
