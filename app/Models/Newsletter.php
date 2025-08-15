<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    /** @use HasFactory<\Database\Factories\NewsletterFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'status',
        'subscribed_at',
        'unsubscribed_at',
        'unsubscribe_token',
        'source',
        'preferences',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'preferences' => 'array',
    ];

    /**
     * Scope a query to only include active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include unsubscribed subscribers.
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    /**
     * Generate unsubscribe token.
     */
    public static function generateUnsubscribeToken()
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * Unsubscribe the subscriber.
     */
    public function unsubscribe()
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }

    /**
     * Resubscribe the subscriber.
     */
    public function resubscribe()
    {
        $this->update([
            'status' => 'active',
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
        ]);
    }
}
