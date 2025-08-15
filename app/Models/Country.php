<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'iso_code_2',
        'iso_code_3',
        'numeric_code',
        'phone_code',
        'capital',
        'currency_code',
        'currency_name',
        'currency_symbol',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the shipping zones for the country.
     */
    public function shippingZones(): HasMany
    {
        return $this->hasMany(ShippingZone::class);
    }

    /**
     * Get the tax rates for the country.
     */
    public function taxRates(): HasMany
    {
        return $this->hasMany(TaxRate::class);
    }

    /**
     * Scope a query to only include active countries.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
