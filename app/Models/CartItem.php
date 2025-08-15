<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the cart item.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product that owns the cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the product variant that owns the cart item.
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Update the item quantity and recalculate total.
     */
    public function updateQuantity($quantity)
    {
        $this->update([
            'quantity' => $quantity,
            'total_price' => $this->unit_price * $quantity,
        ]);

        $this->cart->updateTotals();
    }

    /**
     * Get the display name for the item.
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->product->name;
        if ($this->productVariant) {
            $name .= ' - '.$this->productVariant->name;
        }

        return $name;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });

        static::deleted(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });
    }
}
