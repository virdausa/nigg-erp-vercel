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
		Schema::table('outbound_requests', function (Blueprint $table) {
			$table->decimal('packing_fee', 10, 2)->nullable()->after('notes');
			$table->decimal('shipping_fee', 10, 2)->nullable()->after('packing_fee');
			$table->string('tracking_number')->nullable()->after('shipping_fee');
			$table->decimal('real_volume', 10, 2)->nullable()->after('tracking_number');
			$table->decimal('real_weight', 10, 2)->nullable()->after('real_volume');
		});
	}

	public function down()
	{
		Schema::table('outbound_requests', function (Blueprint $table) {
			$table->dropColumn(['packing_fee', 'shipping_fee', 'tracking_number', 'real_volume', 'real_weight']);
		});
	}

};
