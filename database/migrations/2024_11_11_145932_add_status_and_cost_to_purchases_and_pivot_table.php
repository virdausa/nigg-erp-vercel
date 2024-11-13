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
		Schema::table('purchases', function (Blueprint $table) {
			if (!Schema::hasColumn('purchases', 'status')) {
				$table->string('status')->default('Planned');
			}
		});

		Schema::table('purchase_product', function (Blueprint $table) {
			if (!Schema::hasColumn('purchase_product', 'buying_price')) {
				$table->decimal('buying_price', 10, 2)->nullable();
			}
			if (!Schema::hasColumn('purchase_product', 'total_cost')) {
				$table->decimal('total_cost', 10, 2)->nullable();
			}
		});
	}


	public function down()
	{
		Schema::table('purchases', function (Blueprint $table) {
			$table->dropColumn('status');
		});

		Schema::table('purchase_product', function (Blueprint $table) {
			$table->dropColumn(['buying_price', 'total_cost']);
		});
	}

};
