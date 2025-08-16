<?php

namespace App\Models;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
        'parent_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the products for the category.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the parent category (for sub-categories).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories (sub-categories).
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include root categories (no parent).
     */
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get cached category with relationships
     */
    public static function getCached($identifier)
    {
        $redisService = app(RedisService::class);

        return $redisService->remember(
            RedisService::CATEGORY_PREFIX . (is_numeric($identifier) ? $identifier : 'slug:' . $identifier),
            RedisService::LONG_CACHE_DURATION,
            function () use ($identifier) {
                if (is_numeric($identifier)) {
                    return static::with(['parent', 'children', 'products'])
                        ->find($identifier);
                }
                return static::with(['parent', 'children', 'products'])
                    ->where('slug', $identifier)
                    ->first();
            }
        );
    }

    /**
     * Get cached category tree
     */
    public static function getCachedTree()
    {
        $redisService = app(RedisService::class);

        return $redisService->remember(
            'categories:tree',
            RedisService::LONG_CACHE_DURATION,
            function () {
                return static::with(['children'])
                    ->roots()
                    ->active()
                    ->orderBy('sort_order')
                    ->get();
            }
        );
    }

    /**
     * Clear cache when category is updated
     */
    protected static function booted()
    {
        static::saved(function ($category) {
            $redisService = app(RedisService::class);
            $redisService->clearCategoryCache($category->id);

            // Clear category tree cache
            $redisService->forget('categories:tree');
        });

        static::deleted(function ($category) {
            $redisService = app(RedisService::class);
            $redisService->clearCategoryCache($category->id);
            $redisService->forget('categories:tree');
        });
    }
}
