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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iso_code_2', 2)->unique();
            $table->string('iso_code_3', 3)->unique();
            $table->string('numeric_code', 3)->nullable();
            $table->string('phone_code', 10)->nullable();
            $table->string('capital')->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('currency_name')->nullable();
            $table->string('currency_symbol', 5)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index(['iso_code_2', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
