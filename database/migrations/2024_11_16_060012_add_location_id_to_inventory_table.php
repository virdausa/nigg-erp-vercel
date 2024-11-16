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
		Schema::table('inventory', function (Blueprint $table) {
			$table->unsignedBigInteger('location_id')->nullable()->after('warehouse_id');
			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
		});
	}

	public function down()
	{
		Schema::table('inventory', function (Blueprint $table) {
			$table->dropForeign(['location_id']);
			$table->dropColumn('location_id');
		});
	}

};
