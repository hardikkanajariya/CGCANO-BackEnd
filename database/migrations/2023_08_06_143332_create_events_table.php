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
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->unsignedBigInteger('speaker_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('duration');
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->string('tickets_available');
            $table->unsignedInteger('max_tickets_per_user')->nullable();
            $table->json('audience_type')->nullable();

            // Socials and Links
            $table->string('youtube')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();

            $table->foreign('category_id')->references('id')->on('event_categories')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('set null');
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
