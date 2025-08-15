# Redis Cache Integration Documentation

## Overview

This Laravel ecommerce application has been successfully integrated with Redis cache to improve performance and reduce database load.

## Features Implemented

### 1. Redis Service (`App\Services\RedisService`)

- Centralized cache management service
- Methods for common caching operations (remember, put, get, forget)
- Specific methods for ecommerce entities (products, categories, cart, search)
- Cache key prefixes to avoid conflicts
- Cache statistics and monitoring

### 2. Model Caching

#### Product Model

- `Product::getCached($id)` - Get cached product with relationships
- `Product::getFeatured($limit)` - Get cached featured products
- `Product::getPopular($limit)` - Get cached popular products
- Automatic cache invalidation when product is updated/deleted

#### Category Model

- `Category::getCached($id)` - Get cached category with relationships
- `Category::getCachedTree()` - Get cached category tree structure
- Automatic cache invalidation when category is updated/deleted

### 3. Cache Management

#### Artisan Commands

```bash
# Test cache functionality
php artisan cache:manage test

# View cache statistics
php artisan cache:manage stats

# Clear all cache
php artisan cache:manage clear --type=all

# Clear specific cache types
php artisan cache:manage clear --type=products
php artisan cache:manage clear --type=categories

# Clear cache by pattern
php artisan cache:manage clear --pattern="product:*"

# Warm up cache with common data
php artisan cache:manage warmup
```

#### HTTP API Endpoints

- `GET /cache/stats` - Get cache statistics
- `POST /cache/clear-all` - Clear all cache
- `POST /cache/clear-pattern` - Clear cache by pattern
- `POST /cache/clear-products` - Clear product cache
- `POST /cache/clear-categories` - Clear category cache
- `GET /cache/test` - Test cache functionality
- `POST /cache/warmup` - Warm up cache

### 4. Response Caching Middleware

- `CacheResponse` middleware for caching HTTP responses
- Automatically caches GET requests for non-authenticated users
- Configurable cache duration

### 5. Configuration

#### Environment Variables

```env
# Basic Redis Configuration
CACHE_STORE=redis
CACHE_PREFIX=ecommerce_cache
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1

# Cache Durations
CACHE_DURATION_SHORT=300
CACHE_DURATION_MEDIUM=1800
CACHE_DURATION_LONG=3600
CACHE_DURATION_DAILY=86400
CACHE_DURATION_WEEKLY=604800

# Auto Cache Settings
AUTO_CACHE_PRODUCTS=true
AUTO_CACHE_CATEGORIES=true
AUTO_CACHE_SETTINGS=true
AUTO_CACHE_POPULAR_PRODUCTS=true
AUTO_CACHE_FEATURED_PRODUCTS=true

# Response Caching
ENABLE_RESPONSE_CACHE=true

# Monitoring
CACHE_MONITORING_ENABLED=false
CACHE_LOG_HITS=false
CACHE_LOG_MISSES=false
```

#### Configuration File

Custom configuration is available in `config/redis-cache.php` for fine-tuning cache behavior.

## Usage Examples

### Basic Caching

```php
use App\Services\RedisService;

$redisService = app(RedisService::class);

// Store data
$redisService->put('my_key', $data, 3600);

// Retrieve data
$data = $redisService->get('my_key');

// Remember pattern
$data = $redisService->remember('expensive_operation', 3600, function () {
    return performExpensiveOperation();
});
```

### Using the Facade

```php
use App\Facades\RedisCache;

// Same methods available through facade
RedisCache::put('key', $value, 3600);
$value = RedisCache::get('key');
```

### Model Usage

```php
// Get cached product
$product = Product::getCached(1);

// Get cached featured products
$featured = Product::getFeatured(10);

// Get cached category tree
$categories = Category::getCachedTree();
```

### Cache Management in Controllers

```php
use App\Services\RedisService;

class ProductController extends Controller
{
    public function show($id, RedisService $cache)
    {
        $product = $cache->remember("product:{$id}", 3600, function () use ($id) {
            return Product::with(['category', 'images'])->find($id);
        });

        return view('product.show', compact('product'));
    }
}
```

## Cache Keys Structure

- Products: `product:1`, `product:slug:my-product`
- Categories: `category:1`, `category:slug:electronics`
- Featured Products: `featured:products:10`
- Popular Products: `popular:products:10`
- Category Tree: `categories:tree`
- Search Results: `search:md5(query)`
- Settings: `settings:all`
- HTTP Responses: `response:md5(url)`

## Performance Benefits

1. **Reduced Database Load**: Frequently accessed data is served from memory
2. **Faster Response Times**: Redis operations are much faster than database queries
3. **Scalability**: Redis can handle high concurrent loads
4. **Automatic Invalidation**: Cache is automatically cleared when data changes
5. **Selective Caching**: Different cache durations for different types of data

## Monitoring and Debugging

Use the cache management commands to monitor Redis performance:

- Check memory usage and hit/miss ratios
- Monitor connected clients and processed commands
- Test cache functionality
- Clear problematic cache entries

## Best Practices Implemented

1. **Consistent Key Naming**: Using prefixes to organize cache keys
2. **Appropriate Cache Durations**: Different durations for different data types
3. **Automatic Invalidation**: Cache is cleared when underlying data changes
4. **Error Handling**: Graceful fallback when cache is unavailable
5. **Monitoring**: Built-in tools for cache performance monitoring
6. **Selective Caching**: Only cache data that benefits from caching

## Next Steps

Consider implementing:

1. Cache warming on deployment
2. Cache hit/miss logging for analysis
3. Cache compression for large objects
4. Cache clustering for high availability
5. Cache warming based on user behavior
