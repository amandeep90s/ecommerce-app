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
        Schema::create('search_queries', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address')->nullable();
            $table->integer('results_count')->default(0);
            $table->foreignId('clicked_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('session_id')->nullable();
            $table->timestamps();

            $table->index(['query', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('results_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_queries');
    }
};
