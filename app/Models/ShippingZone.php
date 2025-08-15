<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingZone extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingZoneFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'countries',
        'states',
        'postal_codes',
        'is_active',
    ];

    protected $casts = [
        'countries' => 'array',
        'states' => 'array',
        'postal_codes' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the shipping rates for the shipping zone.
     */
    public function shippingRates(): HasMany
    {
        return $this->hasMany(ShippingRate::class);
    }

    /**
     * Scope a query to only include active shipping zones.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if the zone covers a specific country.
     */
    public function coversCountry($countryCode)
    {
        return in_array($countryCode, $this->countries ?? []);
    }

    /**
     * Check if the zone covers a specific state.
     */
    public function coversState($stateCode)
    {
        return in_array($stateCode, $this->states ?? []);
    }

    /**
     * Check if the zone covers a specific postal code.
     */
    public function coversPostalCode($postalCode)
    {
        if (empty($this->postal_codes)) {
            return true; // No postal code restriction
        }

        foreach ($this->postal_codes as $pattern) {
            if (fnmatch($pattern, $postalCode)) {
                return true;
            }
        }

        return false;
    }
}
