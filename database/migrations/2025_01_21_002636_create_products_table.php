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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index(); // Add index for better search performance
            $table->json('sizes')->nullable(); // Store multiple sizes as JSON
            $table->json('lengths')->nullable(); // Store multiple lengths as JSON
            $table->string('weight')->default('0 kg'); // Default weight
            $table->string('image', 255); // Limit image path length
            $table->string('category')->nullable()->index(); // Add category column with index
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};