<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the orders that have used this coupon.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'coupon_order')
            ->withPivot('discount_amount')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include valid coupons (active and within date range).
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            });
    }

    /**
     * Calculate discount amount for a given order total.
     */
    public function calculateDiscount($orderTotal)
    {
        if (! $this->isValidForAmount($orderTotal)) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $orderTotal);
        }

        // Percentage discount
        $discount = ($orderTotal * $this->value) / 100;

        if ($this->maximum_discount) {
            $discount = min($discount, $this->maximum_discount);
        }

        return $discount;
    }

    /**
     * Check if coupon is valid for the given amount.
     */
    public function isValidForAmount($amount)
    {
        if ($this->minimum_amount && $amount < $this->minimum_amount) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon is valid (active, within date range, usage limits).
     */
    public function isValid($userId = null)
    {
        // Check if active
        if (! $this->is_active) {
            return false;
        }

        // Check date range
        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Check total usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        // Check per-user usage limit
        if ($userId && $this->usage_limit_per_user) {
            $userUsageCount = $this->orders()->whereHas('user', function ($q) use ($userId) {
                $q->where('id', $userId);
            })->count();

            if ($userUsageCount >= $this->usage_limit_per_user) {
                return false;
            }
        }

        return true;
    }

    /**
     * Use the coupon (increment usage count).
     */
    public function use()
    {
        $this->increment('used_count');
    }

    /**
     * Find a valid coupon by code.
     */
    public static function findValidByCode($code, $userId = null)
    {
        $coupon = static::where('code', $code)->first();

        if (! $coupon || ! $coupon->isValid($userId)) {
            return null;
        }

        return $coupon;
    }
}
