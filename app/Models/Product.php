<?php

namespace App\Models;

use App\Services\RedisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'compare_price',
        'cost_price',
        'stock_quantity',
        'track_inventory',
        'is_active',
        'is_featured',
        'weight',
        'dimensions',
        'meta_title',
        'meta_description',
        'category_id',
        'brand_id',
        'vendor_id',
        'tax_class_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'track_inventory' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the vendor that owns the product.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the tax class that owns the product.
     */
    public function taxClass(): BelongsTo
    {
        return $this->belongsTo(TaxClass::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the variants for the product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the attribute values for the product.
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    /**
     * Get the views for the product.
     */
    public function views(): HasMany
    {
        return $this->hasMany(ProductView::class);
    }

    /**
     * Get the tags for the product.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the users who have this product in their wishlist.
     */
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    /**
     * Get the average rating for the product.
     */
    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }

    /**
     * Get the total number of approved reviews.
     */
    public function reviewsCount()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    /**
     * Cache this product
     */
    public function cache($duration = null): void
    {
        $redisService = app(RedisService::class);
        $redisService->cacheProduct($this, $duration ?? RedisService::LONG_CACHE_DURATION);
    }

    /**
     * Get cached product with relationships
     */
    public static function getCached($identifier)
    {
        $redisService = app(RedisService::class);

        return $redisService->remember(
            RedisService::PRODUCT_PREFIX . (is_numeric($identifier) ? $identifier : 'slug:' . $identifier),
            RedisService::LONG_CACHE_DURATION,
            function () use ($identifier) {
                if (is_numeric($identifier)) {
                    return static::with(['category', 'brand', 'images', 'variants', 'reviews'])
                        ->find($identifier);
                }
                return static::with(['category', 'brand', 'images', 'variants', 'reviews'])
                    ->where('slug', $identifier)
                    ->first();
            }
        );
    }

    /**
     * Get cached featured products
     */
    public static function getFeatured($limit = 10)
    {
        $redisService = app(RedisService::class);

        return $redisService->remember(
            'featured:products:' . $limit,
            RedisService::LONG_CACHE_DURATION,
            function () use ($limit) {
                return static::with(['category', 'brand', 'images'])
                    ->where('is_featured', true)
                    ->where('is_active', true)
                    ->limit($limit)
                    ->get();
            }
        );
    }

    /**
     * Get cached popular products
     */
    public static function getPopular($limit = 10)
    {
        $redisService = app(RedisService::class);

        return $redisService->remember(
            'popular:products:' . $limit,
            RedisService::MEDIUM_CACHE_DURATION,
            function () use ($limit) {
                return static::with(['category', 'brand', 'images'])
                    ->where('is_active', true)
                    ->orderBy('created_at', 'desc') // Using created_at instead of views_count for now
                    ->limit($limit)
                    ->get();
            }
        );
    }

    /**
     * Clear cache when product is updated
     */
    protected static function booted()
    {
        static::saved(function ($product) {
            $redisService = app(RedisService::class);
            $redisService->clearProductCache($product->id);

            // Clear related cache
            $redisService->forget('featured:products:10');
            $redisService->forget('popular:products:10');
        });

        static::deleted(function ($product) {
            $redisService = app(RedisService::class);
            $redisService->clearProductCache($product->id);
        });
    }
}
