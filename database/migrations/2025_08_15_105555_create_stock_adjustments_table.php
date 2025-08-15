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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['increase', 'decrease']);
            $table->integer('quantity');
            $table->enum('reason', ['damaged', 'lost', 'found', 'manual', 'return', 'other']);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['product_id', 'warehouse_id']);
            $table->index(['type', 'reason']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
