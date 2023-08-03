<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('wifi')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('catering')->default(false);
            $table->boolean('disabled_access')->default(false);
            $table->boolean('projector')->default(false);
            $table->boolean('microphone')->default(false);
            $table->boolean('sound_system')->default(false);
            $table->boolean('stage')->default(false);
            $table->boolean('screen')->default(false);
            $table->boolean('lighting')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vanues');
    }
};
