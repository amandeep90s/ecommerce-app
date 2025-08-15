<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'shipping_method_id',
        'status',
        'shipped_at',
        'delivered_at',
        'estimated_delivery',
        'shipping_address',
        'weight',
        'dimensions',
        'cost',
        'notes',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery' => 'datetime',
        'shipping_address' => 'array',
        'dimensions' => 'array',
        'weight' => 'decimal:2',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the order that owns the shipment.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the shipping method that was used for the shipment.
     */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    /**
     * Get the tracking information for the shipment.
     */
    public function trackings(): HasMany
    {
        return $this->hasMany(ShipmentTracking::class);
    }

    /**
     * Scope a query to only include shipped shipments.
     */
    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    /**
     * Scope a query to only include delivered shipments.
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }
}
