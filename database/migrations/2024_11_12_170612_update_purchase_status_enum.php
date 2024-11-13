<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdatePurchaseStatusEnum extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Modify the 'status' column to include 'Pending Additional Shipment' as a valid value
        DB::statement("ALTER TABLE purchases MODIFY status ENUM('Planned', 'In Transit', 'Completed', 'Quantity Discrepancy', 'Pending Additional Shipment') DEFAULT 'Planned'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Rollback to the previous ENUM definition, removing 'Pending Additional Shipment'
        DB::statement("ALTER TABLE purchases MODIFY status ENUM('Planned', 'In Transit', 'Completed', 'Quantity Discrepancy') DEFAULT 'Planned'");
    }
}
