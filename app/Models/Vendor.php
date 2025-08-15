<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'tax_id',
        'phone',
        'website',
        'description',
        'logo_url',
        'banner_url',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'commission_rate',
        'status',
        'approved_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /**
     * Get the user that owns the vendor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the vendor.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the commissions for the vendor.
     */
    public function commissions(): HasMany
    {
        return $this->hasMany(VendorCommission::class);
    }

    /**
     * Get the payouts for the vendor.
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(VendorPayout::class);
    }

    /**
     * Get all of the vendor's transactions.
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Scope a query to only include approved vendors.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending vendors.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include active vendors.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
