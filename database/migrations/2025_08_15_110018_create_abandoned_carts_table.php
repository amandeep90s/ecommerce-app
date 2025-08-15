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
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('email')->nullable();
            $table->json('cart_data');
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->timestamp('abandoned_at');
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamp('recovered_at')->nullable();
            $table->string('recovery_token')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['email', 'abandoned_at']);
            $table->index('recovery_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');
    }
};
