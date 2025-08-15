<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'template',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'custom_css',
        'custom_js',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Scope a query to only include published pages.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where(function ($query) {
                        $query->whereNull('published_at')
                              ->orWhere('published_at', '<=', now());
                    });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
