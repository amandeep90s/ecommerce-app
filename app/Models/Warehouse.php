<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    /** @use HasFactory<\Database\Factories\WarehouseFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'email',
        'manager_name',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * Get the inventory transactions for the warehouse.
     */
    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    /**
     * Get the stock adjustments for the warehouse.
     */
    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class);
    }

    /**
     * Get the low stock alerts for the warehouse.
     */
    public function lowStockAlerts(): HasMany
    {
        return $this->hasMany(LowStockAlert::class);
    }

    /**
     * Scope a query to only include active warehouses.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to get the default warehouse.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the full address as a single string.
     */
    public function getFullAddressAttribute()
    {
        return collect([$this->address, $this->city, $this->state, $this->country, $this->postal_code])
            ->filter()
            ->implode(', ');
    }
}
