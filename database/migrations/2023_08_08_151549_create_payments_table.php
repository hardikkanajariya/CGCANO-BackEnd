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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('billing_token');
            $table->string('payment_amount');
            $table->string('facilitator_access_token')->nullable();
            $table->string('paypal_order_id')->nullable();
            $table->string('payer_id');
            $table->string('payer_name')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('payer_address')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('paypal_fee')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('status');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
