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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value');
            $table->enum('type', ['string', 'integer', 'boolean', 'float', 'array', 'json'])->default('string');
            $table->string('group')->default('general');
            $table->boolean('is_public')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['group', 'is_public']);
            $table->index('key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
