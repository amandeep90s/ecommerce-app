<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentTracking extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentTrackingFactory> */
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'description',
        'tracked_at',
        'carrier_status',
        'carrier_description',
    ];

    protected $casts = [
        'tracked_at' => 'datetime',
    ];

    /**
     * Get the shipment that owns the tracking information.
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
