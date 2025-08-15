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
        Schema::create('product_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamp('viewed_at');
            $table->timestamps();

            $table->index(['product_id', 'viewed_at']);
            $table->index(['user_id', 'viewed_at']);
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_views');
    }
};
