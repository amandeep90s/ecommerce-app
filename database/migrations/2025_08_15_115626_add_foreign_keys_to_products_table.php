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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('brand_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            $table->foreignId('vendor_id')->nullable()->after('brand_id')->constrained()->nullOnDelete();
            $table->foreignId('tax_class_id')->nullable()->after('vendor_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['tax_class_id']);
            $table->dropColumn(['brand_id', 'vendor_id', 'tax_class_id']);
        });
    }
};
