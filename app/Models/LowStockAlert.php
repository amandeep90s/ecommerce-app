<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LowStockAlert extends Model
{
    /** @use HasFactory<\Database\Factories\LowStockAlertFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'current_stock',
        'threshold',
        'status',
        'alerted_at',
        'resolved_at',
    ];

    protected $casts = [
        'current_stock' => 'integer',
        'threshold' => 'integer',
        'alerted_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the product that owns the low stock alert.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the low stock alert.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the warehouse that owns the low stock alert.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Scope a query to only include active alerts.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Mark the alert as resolved.
     */
    public function resolve()
    {
        $this->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }
}
