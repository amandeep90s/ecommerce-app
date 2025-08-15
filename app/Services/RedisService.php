<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;

class RedisService
{
    /**
     * Cache duration constants
     */
    const SHORT_CACHE_DURATION = 300; // 5 minutes
    const MEDIUM_CACHE_DURATION = 1800; // 30 minutes
    const LONG_CACHE_DURATION = 3600; // 1 hour
    const DAILY_CACHE_DURATION = 86400; // 24 hours

    /**
     * Cache key prefixes
     */
    const PRODUCT_PREFIX = 'product:';
    const CATEGORY_PREFIX = 'category:';
    const USER_PREFIX = 'user:';
    const CART_PREFIX = 'cart:';
    const ORDER_PREFIX = 'order:';
    const SEARCH_PREFIX = 'search:';
    const SETTINGS_PREFIX = 'settings:';

    /**
     * Get data from cache or execute callback if not cached
     */
    public function remember(string $key, int $duration, callable $callback)
    {
        return Cache::remember($key, $duration, $callback);
    }

    /**
     * Store data in cache
     */
    public function put(string $key, $value, int $duration = self::MEDIUM_CACHE_DURATION): bool
    {
        return Cache::put($key, $value, $duration);
    }

    /**
     * Get data from cache
     */
    public function get(string $key, $default = null)
    {
        return Cache::get($key, $default);
    }

    /**
     * Remove data from cache
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Clear cache by pattern
     */
    public function forgetByPattern(string $pattern): void
    {
        $keys = Redis::keys($pattern);
        if (!empty($keys)) {
            Redis::del($keys);
        }
    }

    /**
     * Cache product data
     */
    public function cacheProduct($product, int $duration = self::LONG_CACHE_DURATION): void
    {
        $key = self::PRODUCT_PREFIX . $product->id;
        $this->put($key, $product, $duration);

        // Cache product with slug
        $slugKey = self::PRODUCT_PREFIX . 'slug:' . $product->slug;
        $this->put($slugKey, $product, $duration);
    }

    /**
     * Get cached product
     */
    public function getProduct($identifier)
    {
        if (is_numeric($identifier)) {
            return $this->get(self::PRODUCT_PREFIX . $identifier);
        }
        return $this->get(self::PRODUCT_PREFIX . 'slug:' . $identifier);
    }

    /**
     * Clear product cache
     */
    public function clearProductCache($productId = null): void
    {
        if ($productId) {
            $this->forget(self::PRODUCT_PREFIX . $productId);
            // Also clear slug cache - we'd need to get the slug first
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $this->forget(self::PRODUCT_PREFIX . 'slug:' . $product->slug);
            }
        } else {
            $this->forgetByPattern(self::PRODUCT_PREFIX . '*');
        }
    }

    /**
     * Cache category data
     */
    public function cacheCategory($category, int $duration = self::LONG_CACHE_DURATION): void
    {
        $key = self::CATEGORY_PREFIX . $category->id;
        $this->put($key, $category, $duration);

        // Cache category with slug
        $slugKey = self::CATEGORY_PREFIX . 'slug:' . $category->slug;
        $this->put($slugKey, $category, $duration);
    }

    /**
     * Get cached category
     */
    public function getCategory($identifier)
    {
        if (is_numeric($identifier)) {
            return $this->get(self::CATEGORY_PREFIX . $identifier);
        }
        return $this->get(self::CATEGORY_PREFIX . 'slug:' . $identifier);
    }

    /**
     * Clear category cache
     */
    public function clearCategoryCache($categoryId = null): void
    {
        if ($categoryId) {
            $this->forget(self::CATEGORY_PREFIX . $categoryId);
            $category = \App\Models\Category::find($categoryId);
            if ($category) {
                $this->forget(self::CATEGORY_PREFIX . 'slug:' . $category->slug);
            }
        } else {
            $this->forgetByPattern(self::CATEGORY_PREFIX . '*');
        }
    }

    /**
     * Cache user cart
     */
    public function cacheUserCart(int $userId, $cartData, int $duration = self::SHORT_CACHE_DURATION): void
    {
        $key = self::CART_PREFIX . $userId;
        $this->put($key, $cartData, $duration);
    }

    /**
     * Get cached user cart
     */
    public function getUserCart(int $userId)
    {
        return $this->get(self::CART_PREFIX . $userId);
    }

    /**
     * Clear user cart cache
     */
    public function clearUserCartCache(int $userId): void
    {
        $this->forget(self::CART_PREFIX . $userId);
    }

    /**
     * Cache search results
     */
    public function cacheSearchResults(string $query, $results, int $duration = self::MEDIUM_CACHE_DURATION): void
    {
        $key = self::SEARCH_PREFIX . md5($query);
        $this->put($key, $results, $duration);
    }

    /**
     * Get cached search results
     */
    public function getSearchResults(string $query)
    {
        $key = self::SEARCH_PREFIX . md5($query);
        return $this->get($key);
    }

    /**
     * Cache application settings
     */
    public function cacheSettings($settings, int $duration = self::DAILY_CACHE_DURATION): void
    {
        $this->put(self::SETTINGS_PREFIX . 'all', $settings, $duration);
    }

    /**
     * Get cached settings
     */
    public function getSettings()
    {
        return $this->get(self::SETTINGS_PREFIX . 'all');
    }

    /**
     * Clear settings cache
     */
    public function clearSettingsCache(): void
    {
        $this->forget(self::SETTINGS_PREFIX . 'all');
    }

    /**
     * Cache popular products
     */
    public function cachePopularProducts($products, int $duration = self::LONG_CACHE_DURATION): void
    {
        $this->put('popular:products', $products, $duration);
    }

    /**
     * Get cached popular products
     */
    public function getPopularProducts()
    {
        return $this->get('popular:products');
    }

    /**
     * Cache featured products
     */
    public function cacheFeaturedProducts($products, int $duration = self::LONG_CACHE_DURATION): void
    {
        $this->put('featured:products', $products, $duration);
    }

    /**
     * Get cached featured products
     */
    public function getFeaturedProducts()
    {
        return $this->get('featured:products');
    }

    /**
     * Flush all cache
     */
    public function flushAll(): void
    {
        Cache::flush();
    }

    /**
     * Get cache statistics
     */
    public function getStats(): array
    {
        try {
            $info = Redis::info();
            return [
                'used_memory' => $info['used_memory_human'] ?? 'N/A',
                'connected_clients' => $info['connected_clients'] ?? 'N/A',
                'total_commands_processed' => $info['total_commands_processed'] ?? 'N/A',
                'keyspace_hits' => $info['keyspace_hits'] ?? 'N/A',
                'keyspace_misses' => $info['keyspace_misses'] ?? 'N/A',
            ];
        } catch (\Exception $e) {
            return ['error' => 'Unable to get Redis stats'];
        }
    }
}
