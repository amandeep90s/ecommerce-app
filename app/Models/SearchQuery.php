<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchQuery extends Model
{
    /** @use HasFactory<\Database\Factories\SearchQueryFactory> */
    use HasFactory;

    protected $fillable = [
        'query',
        'user_id',
        'ip_address',
        'results_count',
        'clicked_product_id',
        'session_id',
    ];

    protected $casts = [
        'results_count' => 'integer',
    ];

    /**
     * Get the user that made the search query.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was clicked from the search results.
     */
    public function clickedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'clicked_product_id');
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to get popular search terms.
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->selectRaw('query, COUNT(*) as search_count')
            ->groupBy('query')
            ->orderBy('search_count', 'desc')
            ->limit($limit);
    }

    /**
     * Scope a query to get searches with no results.
     */
    public function scopeNoResults($query)
    {
        return $query->where('results_count', 0);
    }
}
