<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'url',
        'target',
        'parent_id',
        'sort_order',
        'is_active',
        'icon',
        'css_class',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the parent menu item.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menu items.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    /**
     * Scope a query to only include active menu items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include root menu items.
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to filter by location.
     */
    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }
}
