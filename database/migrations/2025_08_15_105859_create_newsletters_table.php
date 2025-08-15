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
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('status', ['active', 'unsubscribed', 'bounced'])->default('active');
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_token')->unique();
            $table->string('source')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'subscribed_at']);
            $table->index('unsubscribe_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsletters');
    }
};
