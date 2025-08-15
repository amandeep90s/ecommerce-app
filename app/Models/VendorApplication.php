<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorApplication extends Model
{
    /** @use HasFactory<\Database\Factories\VendorApplicationFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'tax_id',
        'phone',
        'website',
        'description',
        'business_documents',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'status',
        'reviewed_at',
        'reviewed_by',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'business_documents' => 'array',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the vendor application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that reviewed the application.
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved applications.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected applications.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
