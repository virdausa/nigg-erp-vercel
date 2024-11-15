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
			$table->date('shipped_date')->nullable();
			$table->string('expedition')->nullable();
			$table->string('tracking_no')->nullable();
		});

		// If you're using a strict ENUM field for `status`, you may need to alter it directly in your database or by editing the ENUM values in a future migration
		Schema::table('purchases', function (Blueprint $table) {
            DB::statement("ALTER TABLE `purchases` MODIFY `status` ENUM('Planned', 'In Transit', 'Received - Pending Verification', 'Quantity Discrepancy', 'Completed', 'Pending Additional Shipment') NOT NULL");
        });
	}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            //
        });
    }
};
