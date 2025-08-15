<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'product_sku',
        'product_details',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'product_details' => 'array',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the order item.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get the display name for the order item.
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->product_name;
        if ($this->productVariant) {
            $name .= ' - ' . $this->productVariant->name;
        }
        return $name;
    }

    /**
     * Create order item from cart item.
     */
    public static function createFromCartItem(CartItem $cartItem, Order $order)
    {
        return static::create([
            'order_id' => $order->id,
            'product_id' => $cartItem->product_id,
            'product_variant_id' => $cartItem->product_variant_id,
            'product_name' => $cartItem->product->name,
            'product_sku' => $cartItem->productVariant?->sku ?? $cartItem->product->sku,
            'product_details' => [
                'description' => $cartItem->product->description,
                'variant_attributes' => $cartItem->productVariant?->attributes,
            ],
            'quantity' => $cartItem->quantity,
            'unit_price' => $cartItem->unit_price,
            'total_price' => $cartItem->total_price,
        ]);
    }
}
