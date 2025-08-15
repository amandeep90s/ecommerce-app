<?php

namespace App\Http\Middleware;

use App\Services\RedisService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    protected $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $duration = 300): Response
    {
        // Only cache GET requests
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        // Skip caching for authenticated users or if cache is disabled
        if ($request->user() || !config('cache.enable_response_cache', true)) {
            return $next($request);
        }

        // Create cache key based on URL and query parameters
        $cacheKey = 'response:' . md5($request->fullUrl());

        // Try to get cached response
        $cachedResponse = $this->redisService->get($cacheKey);

        if ($cachedResponse) {
            return response($cachedResponse['content'])
                ->withHeaders($cachedResponse['headers'])
                ->setStatusCode($cachedResponse['status']);
        }

        // Execute the request
        $response = $next($request);

        // Only cache successful responses
        if ($response->getStatusCode() === 200) {
            $responseData = [
                'content' => $response->getContent(),
                'headers' => $response->headers->all(),
                'status' => $response->getStatusCode(),
            ];

            $this->redisService->put($cacheKey, $responseData, $duration);
        }

        return $response;
    }
}
