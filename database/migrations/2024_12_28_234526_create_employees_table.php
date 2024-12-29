<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('id_employee');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->date('reg_date'); // Registration date
            $table->date('out_date')->nullable(); // Out date (nullable)
            $table->boolean('status')->default(true); // Active (true) or inactive (false)
            $table->foreignId('role_id')->nullable()->constrained()->onDelete('cascade'); // Links to roles table
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
