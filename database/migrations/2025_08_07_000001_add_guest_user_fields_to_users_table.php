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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_guest_account')->default(false)->after('password')->comment('Flag to identify guest accounts');
            $table->timestamp('temp_password_sent_at')->nullable()->after('is_guest_account')->comment('When temporary password was sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'is_guest_account', 'temp_password_sent_at']);
        });
    }
};
