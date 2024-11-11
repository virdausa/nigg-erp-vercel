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
		Schema::create('sales', function (Blueprint $table) {
			$table->id();
			$table->string('customer_name');
			$table->date('sale_date');
			$table->decimal('total_amount', 10, 2)->default(0);
			$table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
			$table->timestamps();
		});
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
