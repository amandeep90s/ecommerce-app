<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class StockAdjustment extends Model
{
    /** @use HasFactory<\Database\Factories\StockAdjustmentFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'type',
        'quantity',
        'reason',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the product that owns the stock adjustment.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the stock adjustment.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the warehouse that owns the stock adjustment.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the user that created the stock adjustment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the adjustment's inventory transactions.
     */
    public function inventoryTransactions(): MorphMany
    {
        return $this->morphMany(InventoryTransaction::class, 'reference');
    }
}
