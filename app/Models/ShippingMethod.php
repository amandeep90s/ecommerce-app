<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingMethodFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'carrier',
        'is_active',
        'base_cost',
        'per_item_cost',
        'per_weight_cost',
        'free_shipping_threshold',
        'estimated_days_min',
        'estimated_days_max',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_cost' => 'decimal:2',
        'per_item_cost' => 'decimal:2',
        'per_weight_cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'estimated_days_min' => 'integer',
        'estimated_days_max' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get the shipping rates for the shipping method.
     */
    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }

    /**
     * Get the shipments that used this shipping method.
     */
    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * Scope a query to only include active shipping methods.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate shipping cost for given weight and item count.
     */
    public function calculateCost($weight = 0, $itemCount = 0, $orderTotal = 0)
    {
        // Check if order qualifies for free shipping
        if ($this->free_shipping_threshold && $orderTotal >= $this->free_shipping_threshold) {
            return 0;
        }

        $cost = $this->base_cost;
        $cost += $this->per_item_cost * $itemCount;
        $cost += $this->per_weight_cost * $weight;

        return max(0, $cost);
    }
}
