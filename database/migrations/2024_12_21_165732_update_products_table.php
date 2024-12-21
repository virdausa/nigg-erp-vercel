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
        Schema::table('products', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('sku')->after('nama');
            $table->integer('berat')->after('price');
            $table->enum('status', ['active', 'non-active'])->after('berat');
            $table->text('note')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('sku');
            $table->dropColumn('berat');
            $table->dropColumn('status');
            $table->dropColumn('note');
        });
    }
};
