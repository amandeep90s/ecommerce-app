<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxRule extends Model
{
    /** @use HasFactory<\Database\Factories\TaxRuleFactory> */
    use HasFactory;

    protected $fillable = [
        'tax_class_id',
        'tax_rate_id',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the tax class that owns the tax rule.
     */
    public function taxClass(): BelongsTo
    {
        return $this->belongsTo(TaxClass::class);
    }

    /**
     * Get the tax rate that owns the tax rule.
     */
    public function taxRate(): BelongsTo
    {
        return $this->belongsTo(TaxRate::class);
    }

    /**
     * Scope a query to only include active tax rules.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
