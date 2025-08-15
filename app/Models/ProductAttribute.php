<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAttribute extends Model
{
    /** @use HasFactory<\Database\Factories\ProductAttributeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'is_required',
        'is_filterable',
        'is_visible',
        'sort_order',
        'validation_rules',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_filterable' => 'boolean',
        'is_visible' => 'boolean',
        'sort_order' => 'integer',
        'validation_rules' => 'array',
    ];

    /**
     * Get the attribute values for the product attribute.
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'attribute_id');
    }

    /**
     * Scope a query to only include visible attributes.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope a query to only include filterable attributes.
     */
    public function scopeFilterable($query)
    {
        return $query->where('is_filterable', true);
    }

    /**
     * Scope a query to only include required attributes.
     */
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
}
