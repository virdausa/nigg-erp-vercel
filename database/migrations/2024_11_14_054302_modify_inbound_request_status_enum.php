<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyInboundRequestStatusEnum extends Migration
{
    public function up()
    {
        Schema::table('inbound_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE `inbound_requests` MODIFY `status` ENUM('In Transit', 'Received - Pending Verification', 'Quantity Discrepancy', 'Completed', 'Ready to Complete') NOT NULL");
        });
    }

    public function down()
    {
        Schema::table('inbound_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE `inbound_requests` MODIFY `status` ENUM('In Transit', 'Received - Pending Verification', 'Quantity Discrepancy', 'Completed') NOT NULL");
        });
    }
}

