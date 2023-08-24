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
        Schema::table('invoice_packages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('total_amount');
            $table->boolean('is_paid')->default(false);
            $table->integer('status')->default(0);
            $table->string('pdf')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_id')->references('id')->on('membership_packages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_packages', function (Blueprint $table) {
            //
        });
    }
};
