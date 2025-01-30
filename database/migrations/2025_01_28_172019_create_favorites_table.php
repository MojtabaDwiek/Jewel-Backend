<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // ID of the user (Customer or Retailer)
        $table->string('user_type'); // Type of the user (App\Models\Customers or App\Models\Retailer)
        $table->unsignedBigInteger('product_id'); // ID of the product
        $table->timestamps();

        // Foreign key constraint for products
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
