<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxClass extends Model
{
    /** @use HasFactory<\Database\Factories\TaxClassFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products for the tax class.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the tax rules for the tax class.
     */
    public function taxRules(): HasMany
    {
        return $this->hasMany(TaxRule::class);
    }

    /**
     * Scope a query to only include active tax classes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
