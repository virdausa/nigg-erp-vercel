<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
	{
		DB::statement("ALTER TABLE outbound_requests MODIFY COLUMN status ENUM('Requested', 'Pending Confirmation', 'Packing & Shipping', 'In Transit', 'Customer Complaint', 'Ready to Complete', 'Completed') DEFAULT 'Requested'");
	}

	public function down()
	{
		DB::statement("ALTER TABLE outbound_requests MODIFY COLUMN status ENUM('Requested', 'Pending Confirmation', 'Packing & Shipping', 'In Transit', 'Customer Complaint') DEFAULT 'Requested'");
	}

};
