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
        // Temporarily update existing values to avoid mismatch issues
        //DB::table('inbound_requests')->whereNotIn('status', ['In Transit', 'Received - Pending Verification', 'Quantity Discrepancy', 'Completed'])->update(['status' => 'In Transit']);

        // Drop the existing status column
        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Re-add the status column with new ENUM values
        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->enum('status', ['In Transit', 'Received - Pending Verification', 'Quantity Discrepancy', 'Completed'])->default('In Transit')->after('received_quantities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Roll back to the original ENUM values
        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('received_quantities');
        });
    }
};

