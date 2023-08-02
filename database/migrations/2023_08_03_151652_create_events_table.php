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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('category');
            $table->string('description');
            $table->string('location');
            $table->string('date');
            $table->string('time');
            $table->string('duration');
            $table->string('img');
            $table->string('link');
            $table->string('status');
            $table->string('price');
            $table->string('capacity');
            $table->boolean('show_attendees')->default(true);
            $table->boolean('show_sponsors')->default(true);
            $table->boolean('show_speakers')->default(true);
            $table->boolean('show_venue')->default(true);
            $table->boolean('show_map')->default(true);

            $table->boolean('enable_registration')->default(true);
            $table->boolean('enable_sponsors')->default(true);
            $table->boolean('enable_reviews')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
