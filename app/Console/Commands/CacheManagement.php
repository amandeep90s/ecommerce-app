<?php

namespace App\Console\Commands;

use App\Services\RedisService;
use Illuminate\Console\Command;

class CacheManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:manage
                            {action : The action to perform (stats|clear|warmup|test)}
                            {--pattern= : Pattern for clearing specific cache keys}
                            {--type= : Type of cache to clear (products|categories|all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage Redis cache for the ecommerce application';

    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        parent::__construct();
        $this->redisService = $redisService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'stats':
                $this->showStats();
                break;
            case 'clear':
                $this->clearCache();
                break;
            case 'warmup':
                $this->warmupCache();
                break;
            case 'test':
                $this->testCache();
                break;
            default:
                $this->error('Invalid action. Available actions: stats, clear, warmup, test');
                return 1;
        }

        return 0;
    }

    private function showStats()
    {
        $this->info('Redis Cache Statistics:');
        $this->line('─────────────────────────');

        $stats = $this->redisService->getStats();

        foreach ($stats as $key => $value) {
            $this->line("<info>{$key}:</info> {$value}");
        }

        $this->line('─────────────────────────');
        $this->info('Cache Store: ' . config('cache.default'));
    }

    private function clearCache()
    {
        $type = $this->option('type');
        $pattern = $this->option('pattern');

        if ($pattern) {
            $this->redisService->forgetByPattern($pattern);
            $this->info("Cache cleared for pattern: {$pattern}");
            return;
        }

        switch ($type) {
            case 'products':
                $this->redisService->clearProductCache();
                $this->info('Product cache cleared successfully');
                break;
            case 'categories':
                $this->redisService->clearCategoryCache();
                $this->info('Category cache cleared successfully');
                break;
            case 'all':
            default:
                if ($this->confirm('Are you sure you want to clear all cache?')) {
                    $this->redisService->flushAll();
                    $this->info('All cache cleared successfully');
                } else {
                    $this->info('Cache clear cancelled');
                }
                break;
        }
    }

    private function warmupCache()
    {
        $this->info('Warming up cache...');

        try {
            // Cache featured products
            \App\Models\Product::getFeatured(10);
            $this->line('✓ Featured products cached');

            // Cache popular products
            \App\Models\Product::getPopular(10);
            $this->line('✓ Popular products cached');

            // Cache category tree
            \App\Models\Category::getCachedTree();
            $this->line('✓ Category tree cached');

            $this->info('Cache warmup completed successfully!');
        } catch (\Exception $e) {
            $this->error('Cache warmup failed: ' . $e->getMessage());
        }
    }

    private function testCache()
    {
        $this->info('Testing Redis cache...');

        try {
            // Test basic operations
            $testKey = 'cache_test_' . time();
            $testValue = ['message' => 'Test value', 'timestamp' => now()];

            // Store
            $this->redisService->put($testKey, $testValue, 60);
            $this->line('✓ Cache store test passed');

            // Retrieve
            $cachedValue = $this->redisService->get($testKey);
            if ($cachedValue && $cachedValue['message'] === 'Test value') {
                $this->line('✓ Cache retrieve test passed');
            } else {
                $this->error('✗ Cache retrieve test failed');
                return;
            }

            // Delete
            $this->redisService->forget($testKey);
            $deletedValue = $this->redisService->get($testKey);
            if ($deletedValue === null) {
                $this->line('✓ Cache delete test passed');
            } else {
                $this->error('✗ Cache delete test failed');
                return;
            }

            $this->info('All cache tests passed successfully!');
        } catch (\Exception $e) {
            $this->error('Cache test failed: ' . $e->getMessage());
        }
    }
}
