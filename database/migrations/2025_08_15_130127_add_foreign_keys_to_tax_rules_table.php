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
        Schema::table('tax_rules', function (Blueprint $table) {
            $table->foreignId('tax_class_id')->constrained('tax_classes')->onDelete('cascade');
            $table->foreignId('tax_rate_id')->constrained('tax_rates')->onDelete('cascade');
            $table->unique(['tax_class_id', 'tax_rate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tax_rules', function (Blueprint $table) {
            $table->dropForeign(['tax_class_id']);
            $table->dropForeign(['tax_rate_id']);
            $table->dropUnique(['tax_class_id', 'tax_rate_id']);
        });
    }
};
