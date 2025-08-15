<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class InventoryTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryTransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'type',
        'quantity',
        'reference_id',
        'reference_type',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Get the product that owns the inventory transaction.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the inventory transaction.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the warehouse that owns the inventory transaction.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Get the user that created the inventory transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning reference model (order, adjustment, etc).
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
