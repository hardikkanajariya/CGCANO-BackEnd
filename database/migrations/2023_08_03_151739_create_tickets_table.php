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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('price');
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('quantity')->nullable();
            $table->string('event_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('order_id')->nullable();

            // Barcode Details
            $table->string('barcode_id')->unique();
            $table->boolean('barcode_status')->default(true);
            $table->string('barcode_data')->nullable();

            // Payment Details
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_currency')->nullable();
            $table->string('payment_timestamp')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->string('payment_description')->nullable();
            $table->string('payment_request')->nullable();
            $table->string('payment_response')->nullable();
            $table->string('payment_error_message')->nullable();
            $table->string('payment_error_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
