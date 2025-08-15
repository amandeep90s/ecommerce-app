<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicket extends Model
{
    /** @use HasFactory<\Database\Factories\SupportTicketFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'priority',
        'status',
        'assigned_to',
        'order_id',
        'category',
        'last_response_at',
        'closed_at',
    ];

    protected $casts = [
        'last_response_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the support ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the agent assigned to the support ticket.
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the order related to the support ticket.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the messages for the support ticket.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }

    /**
     * Scope a query to only include open tickets.
     */
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }

    /**
     * Scope a query to only include closed tickets.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Scope a query to filter by priority.
     */
    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }
}
