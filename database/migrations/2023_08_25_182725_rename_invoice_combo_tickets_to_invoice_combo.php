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
        Schema::rename('invoice_combo_tickets', 'invoice_combo');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('invoice_combo', 'invoice_combo_tickets');
    }
};
