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
		Schema::table('inbound_requests', function (Blueprint $table) {
			$table->json('requested_quantities')->nullable()->after('warehouse_id');
		});
	}

	public function down()
	{
		Schema::table('inbound_requests', function (Blueprint $table) {
			$table->dropColumn('requested_quantities');
		});
	}

};
