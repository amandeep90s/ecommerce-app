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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('payment_method'); // stripe, paypal, credit_card, etc.
            $table->string('payment_gateway'); // stripe, paypal, square, etc.
            $table->string('transaction_id')->nullable();
            $table->string('gateway_payment_id')->nullable(); // Payment ID from gateway
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded', 'partially_refunded']);
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->default(0); // Gateway fees
            $table->string('currency', 3)->default('USD');
            $table->json('gateway_response')->nullable(); // Store gateway response
            $table->timestamp('processed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'status']);
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
