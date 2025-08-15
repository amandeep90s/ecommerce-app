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
        Schema::create('low_stock_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->integer('current_stock');
            $table->integer('threshold');
            $table->enum('status', ['active', 'resolved'])->default('active');
            $table->timestamp('alerted_at');
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'alerted_at']);
            $table->index(['product_id', 'warehouse_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('low_stock_alerts');
    }
};
