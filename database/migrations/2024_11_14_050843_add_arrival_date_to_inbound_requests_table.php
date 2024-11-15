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
			$table->date('arrival_date')->nullable()->after('status');
		});
	}

	public function down()
	{
		Schema::table('inbound_requests', function (Blueprint $table) {
			$table->dropColumn('arrival_date');
		});
	}

};
