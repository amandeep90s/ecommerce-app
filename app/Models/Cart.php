<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'total_amount',
        'total_items',
        'expires_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart items for the cart.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Add an item to the cart.
     */
    public function addItem($product, $variant = null, $quantity = 1)
    {
        $existingItem = $this->cartItems()
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant?->id)
            ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            $existingItem->update(['total_price' => $existingItem->quantity * $existingItem->unit_price]);
        } else {
            $unitPrice = $variant ? $variant->getEffectivePrice() : $product->price;
            $this->cartItems()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant?->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
            ]);
        }

        $this->updateTotals();
    }

    /**
     * Update cart totals.
     */
    public function updateTotals()
    {
        $this->total_amount = $this->cartItems()->sum('total_price');
        $this->total_items = $this->cartItems()->sum('quantity');
        $this->save();
    }

    /**
     * Check if cart is expired.
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Clear all items from the cart.
     */
    public function clear()
    {
        $this->cartItems()->delete();
        $this->update([
            'total_amount' => 0,
            'total_items' => 0,
        ]);
    }
}
