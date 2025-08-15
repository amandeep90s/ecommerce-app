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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->default('main');
            $table->string('url');
            $table->enum('target', ['_self', '_blank', '_parent', '_top'])->default('_self');
            $table->foreignId('parent_id')->nullable()->constrained('menus')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('icon')->nullable();
            $table->string('css_class')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['location', 'is_active', 'sort_order']);
            $table->index(['parent_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
