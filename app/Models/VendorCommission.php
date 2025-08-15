<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorCommission extends Model
{
    /** @use HasFactory<\Database\Factories\VendorCommissionFactory> */
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'order_id',
        'order_item_id',
        'amount',
        'commission_rate',
        'commission_amount',
        'status',
        'calculated_at',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'calculated_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the vendor that owns the commission.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the order that generated the commission.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the order item that generated the commission.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Scope a query to only include pending commissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid commissions.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('calculated_at', [$startDate, $endDate]);
    }
}
