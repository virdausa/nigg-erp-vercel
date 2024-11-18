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
			$table->enum('status', [
				'Planned', 'Unpaid', 'Pending Shipment', 'In Transit', 
				'Received - Pending Verification', 'Customer Complain', 'Completed'
			])->default('Planned')->after('warehouse_id');
			$table->text('customer_notes')->nullable()->after('status');
			$table->text('admin_notes')->nullable()->after('customer_notes');
		});
	}

	public function down()
	{
		Schema::table('sales', function (Blueprint $table) {
			$table->dropColumn(['status', 'customer_notes', 'admin_notes']);
		});
	}

};
