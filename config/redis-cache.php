<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enable Response Caching
    |--------------------------------------------------------------------------
    |
    | This option controls whether HTTP response caching is enabled.
    | Set to false to disable response caching globally.
    |
    */
    'enable_response_cache' => env('ENABLE_RESPONSE_CACHE', true),

    /*
    |--------------------------------------------------------------------------
    | Default Cache Durations
    |--------------------------------------------------------------------------
    |
    | Define default cache durations for different types of data.
    | Values are in seconds.
    |
    */
    'durations' => [
        'short' => env('CACHE_DURATION_SHORT', 300),      // 5 minutes
        'medium' => env('CACHE_DURATION_MEDIUM', 1800),   // 30 minutes
        'long' => env('CACHE_DURATION_LONG', 3600),       // 1 hour
        'daily' => env('CACHE_DURATION_DAILY', 86400),    // 24 hours
        'weekly' => env('CACHE_DURATION_WEEKLY', 604800), // 7 days
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Keys Prefixes
    |--------------------------------------------------------------------------
    |
    | Define prefixes for different types of cached data to avoid conflicts
    | and make cache management easier.
    |
    */
    'prefixes' => [
        'product' => 'product:',
        'category' => 'category:',
        'user' => 'user:',
        'cart' => 'cart:',
        'order' => 'order:',
        'search' => 'search:',
        'settings' => 'settings:',
        'response' => 'response:',
        'session' => 'session:',
        'popular' => 'popular:',
        'featured' => 'featured:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure which models should be automatically cached when accessed.
    |
    */
    'auto_cache' => [
        'products' => env('AUTO_CACHE_PRODUCTS', true),
        'categories' => env('AUTO_CACHE_CATEGORIES', true),
        'settings' => env('AUTO_CACHE_SETTINGS', true),
        'popular_products' => env('AUTO_CACHE_POPULAR_PRODUCTS', true),
        'featured_products' => env('AUTO_CACHE_FEATURED_PRODUCTS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Warming
    |--------------------------------------------------------------------------
    |
    | Configure which data should be preloaded into cache during warmup.
    |
    */
    'warmup' => [
        'featured_products_limit' => 10,
        'popular_products_limit' => 10,
        'categories_tree' => true,
        'settings' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Tags
    |--------------------------------------------------------------------------
    |
    | Enable cache tagging for easier cache invalidation.
    | Note: This requires a cache driver that supports tagging.
    |
    */
    'enable_tags' => env('CACHE_ENABLE_TAGS', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Monitoring
    |--------------------------------------------------------------------------
    |
    | Enable cache hit/miss monitoring and logging.
    |
    */
    'monitoring' => [
        'enabled' => env('CACHE_MONITORING_ENABLED', false),
        'log_hits' => env('CACHE_LOG_HITS', false),
        'log_misses' => env('CACHE_LOG_MISSES', false),
    ],
];
