<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReceivedQuantitiesColumnInInboundRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->json('received_quantities')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inbound_requests', function (Blueprint $table) {
            $table->json('received_quantities')->nullable(false)->change();
        });
    }
}
