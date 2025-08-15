<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxRate extends Model
{
    /** @use HasFactory<\Database\Factories\TaxRateFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'type',
        'country_id',
        'state',
        'city',
        'postal_code',
        'is_active',
        'priority',
    ];

    protected $casts = [
        'rate' => 'decimal:4',
        'is_active' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get the country that owns the tax rate.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the tax rules for the tax rate.
     */
    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }

    /**
     * Scope a query to only include active tax rates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeForLocation($query, $countryId, $state = null, $city = null, $postalCode = null)
    {
        return $query->where('country_id', $countryId)
            ->where(function ($query) use ($state) {
                $query->whereNull('state')
                    ->orWhere('state', $state);
            })
            ->where(function ($query) use ($city) {
                $query->whereNull('city')
                    ->orWhere('city', $city);
            })
            ->where(function ($query) use ($postalCode) {
                $query->whereNull('postal_code')
                    ->orWhere('postal_code', $postalCode);
            });
    }
}
