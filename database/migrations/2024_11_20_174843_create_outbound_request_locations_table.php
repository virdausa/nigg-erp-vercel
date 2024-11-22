<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('outbound_request_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('outbound_request_id'); // Reference to outbound_requests
            $table->unsignedBigInteger('product_id');         // Reference to products
            $table->unsignedBigInteger('location_id');         // Reference to location
            $table->integer('quantity');                      // Quantity picked from this location
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('outbound_request_id')->references('id')->on('outbound_requests')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbound_request_locations');
    }
};
