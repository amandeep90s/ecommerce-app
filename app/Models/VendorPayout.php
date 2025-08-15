<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorPayout extends Model
{
    /** @use HasFactory<\Database\Factories\VendorPayoutFactory> */
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'amount',
        'currency',
        'method',
        'status',
        'reference_number',
        'transaction_id',
        'fees',
        'net_amount',
        'processed_at',
        'notes',
        'bank_details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fees' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'bank_details' => 'array',
    ];

    /**
     * Get the vendor that owns the payout.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the commissions included in this payout.
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(VendorCommission::class, 'payout_id');
    }

    /**
     * Scope a query to only include pending payouts.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include processed payouts.
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    /**
     * Scope a query to only include failed payouts.
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Generate unique reference number.
     */
    public static function generateReferenceNumber()
    {
        $prefix = 'PAY-';
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(substr(uniqid(), -4));

        return $prefix.$timestamp.$random;
    }
}
