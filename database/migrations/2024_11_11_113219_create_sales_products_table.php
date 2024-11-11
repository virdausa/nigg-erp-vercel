<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_sales_products_table.php
	public function up()
	{
		Schema::create('sales_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
			$table->foreignId('product_id')->constrained()->onDelete('cascade');
			$table->integer('quantity');
			$table->decimal('price', 10, 2);
			$table->timestamps();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_products');
    }
};
