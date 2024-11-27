<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerComplaintsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_order_id');
            $table->text('description')->nullable();
            $table->enum('status', ['Logged', 'In Review', 'Resolved'])->default('Logged');
            $table->timestamps();

            $table->foreign('sales_order_id')->references('id')->on('sales')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_complaints');
    }
}

