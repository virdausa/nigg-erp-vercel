<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inbound_requests', function (Blueprint $table) {
			$table->id();
			$table->foreignId('purchase_order_id')->constrained('purchases')->onDelete('cascade');
			$table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
			$table->json('received_quantities'); // JSON field to store received quantities per product
			$table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
			$table->foreignId('verified_by')->nullable()->constrained('users'); // To track who verified
			$table->text('notes')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inbound_requests');
    }
};
