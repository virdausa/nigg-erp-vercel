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
			$table->json('received_quantities')->nullable(); // Add received_quantities column
		});
	}

	public function down()
	{
		Schema::table('outbound_requests', function (Blueprint $table) {
			$table->dropColumn('received_quantities');
		});
	}
};
