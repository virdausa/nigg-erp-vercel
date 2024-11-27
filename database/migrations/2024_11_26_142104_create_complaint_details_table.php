<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('complaint_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_complaint_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('type', ['Damaged', 'Missing', 'Excess']);
            $table->integer('quantity')->nullable(); // Problematic quantity
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('customer_complaint_id')->references('id')->on('customer_complaints')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('complaint_details');
    }
}
