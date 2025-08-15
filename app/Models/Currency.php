<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /** @use HasFactory<\Database\Factories\CurrencyFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'exchange_rate',
        'is_default',
        'is_active',
        'decimal_places',
    ];

    protected $casts = [
        'exchange_rate' => 'decimal:6',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'decimal_places' => 'integer',
    ];

    /**
     * Scope a query to only include active currencies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to get the default currency.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Convert amount from base currency to this currency.
     */
    public function convertFromBase($amount)
    {
        return $amount * $this->exchange_rate;
    }

    /**
     * Convert amount from this currency to base currency.
     */
    public function convertToBase($amount)
    {
        return $amount / $this->exchange_rate;
    }
}
