<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'currency',
        'status',
        'notes',
        'billing_address',
        'items',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'billing_address' => 'array',
        'items' => 'array',
    ];

    /**
     * Get the order that owns the invoice.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Generate unique invoice number.
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-';
        $year = date('Y');
        $month = date('m');
        $lastInvoice = self::whereYear('created_at', $year)
                          ->whereMonth('created_at', $month)
                          ->orderBy('id', 'desc')
                          ->first();

        $sequence = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -4)) + 1 : 1;

        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
