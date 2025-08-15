<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttributeValue extends Model
{
    /** @use HasFactory<\Database\Factories\ProductAttributeValueFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the product that owns the attribute value.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the attribute that owns the attribute value.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
