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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['text', 'textarea', 'number', 'select', 'multiselect', 'boolean', 'date'])->default('text');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filterable')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('validation_rules')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_visible', 'sort_order']);
            $table->index(['is_filterable', 'is_visible']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
