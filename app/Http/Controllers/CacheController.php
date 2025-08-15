<?php

namespace App\Http\Controllers;

use App\Services\RedisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * Display cache statistics
     */
    public function stats()
    {
        $stats = $this->redisService->getStats();

        return response()->json([
            'redis_stats' => $stats,
            'cache_store' => config('cache.default'),
        ]);
    }

    /**
     * Clear all cache
     */
    public function clearAll()
    {
        $this->redisService->flushAll();

        return response()->json([
            'message' => 'All cache cleared successfully'
        ]);
    }

    /**
     * Clear specific cache by key pattern
     */
    public function clearByPattern(Request $request)
    {
        $pattern = $request->input('pattern');

        if (!$pattern) {
            return response()->json([
                'error' => 'Pattern is required'
            ], 400);
        }

        $this->redisService->forgetByPattern($pattern);

        return response()->json([
            'message' => "Cache cleared for pattern: {$pattern}"
        ]);
    }

    /**
     * Clear product cache
     */
    public function clearProducts(Request $request)
    {
        $productId = $request->input('product_id');
        $this->redisService->clearProductCache($productId);

        return response()->json([
            'message' => $productId ? "Product {$productId} cache cleared" : 'All product cache cleared'
        ]);
    }

    /**
     * Clear category cache
     */
    public function clearCategories(Request $request)
    {
        $categoryId = $request->input('category_id');
        $this->redisService->clearCategoryCache($categoryId);

        return response()->json([
            'message' => $categoryId ? "Category {$categoryId} cache cleared" : 'All category cache cleared'
        ]);
    }

    /**
     * Test cache functionality
     */
    public function test()
    {
        // Test basic caching
        $testKey = 'cache_test_' . time();
        $testValue = ['message' => 'Cache is working!', 'timestamp' => now()];

        // Store in cache
        $this->redisService->put($testKey, $testValue, 60);

        // Retrieve from cache
        $cachedValue = $this->redisService->get($testKey);

        // Clear test cache
        $this->redisService->forget($testKey);

        return response()->json([
            'test_result' => 'success',
            'cached_value' => $cachedValue,
            'message' => 'Redis cache is working properly'
        ]);
    }

    /**
     * Warm up cache with common data
     */
    public function warmup()
    {
        try {
            // Cache featured products
            \App\Models\Product::getFeatured(10);

            // Cache popular products
            \App\Models\Product::getPopular(10);

            // Cache category tree
            \App\Models\Category::getCachedTree();

            return response()->json([
                'message' => 'Cache warmed up successfully',
                'cached_items' => [
                    'featured_products',
                    'popular_products',
                    'category_tree'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to warm up cache: ' . $e->getMessage()
            ], 500);
        }
    }
}
