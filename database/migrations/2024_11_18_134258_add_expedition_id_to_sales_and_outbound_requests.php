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
		Schema::table('sales', function (Blueprint $table) {
			$table->foreignId('expedition_id')->nullable()->constrained('expeditions')->onDelete('set null');
			$table->decimal('estimated_shipping_fee', 10, 2)->nullable();
		});

		Schema::table('outbound_requests', function (Blueprint $table) {
			$table->foreignId('expedition_id')->nullable()->constrained('expeditions')->onDelete('set null');
			$table->decimal('real_shipping_fee', 10, 2)->nullable();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_and_outbound_requests', function (Blueprint $table) {
            //
        });
    }
};
