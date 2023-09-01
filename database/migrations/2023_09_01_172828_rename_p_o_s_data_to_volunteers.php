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
        Schema::rename('p_o_s_data', 'volunteers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('volunteers', 'p_o_s_data');
    }
};
