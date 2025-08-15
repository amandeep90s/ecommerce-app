<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->morphs('transactionable'); // for orders, vendors, etc.
            $table->enum('type', ['payment', 'refund', 'payout', 'commission', 'fee']);
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['pending', 'success', 'failed', 'cancelled', 'refunded']);
            $table->string('gateway')->nullable(); // stripe, paypal, etc.
            $table->string('gateway_transaction_id')->nullable();
            $table->json('gateway_response')->nullable();
            $table->decimal('fees', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2);
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('gateway_transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
