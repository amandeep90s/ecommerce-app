<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingRate extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingRateFactory> */
    use HasFactory;

    protected $fillable = [
        'shipping_method_id',
        'shipping_zone_id',
        'weight_min',
        'weight_max',
        'cost',
        'is_active',
    ];

    protected $casts = [
        'weight_min' => 'decimal:2',
        'weight_max' => 'decimal:2',
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the shipping method that owns the shipping rate.
     */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    /**
     * Get the shipping zone that owns the shipping rate.
     */
    public function shippingZone(): BelongsTo
    {
        return $this->belongsTo(ShippingZone::class);
    }

    /**
     * Scope a query to only include active shipping rates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by weight range.
     */
    public function scopeForWeight($query, $weight)
    {
        return $query->where('weight_min', '<=', $weight)
            ->where(function ($query) use ($weight) {
                $query->whereNull('weight_max')
                    ->orWhere('weight_max', '>=', $weight);
            });
    }
}
