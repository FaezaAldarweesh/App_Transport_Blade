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
        Schema::create('trip_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->string('location'); //32°36'12.6"N 36°39'34.6"E
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_tracks');
    }
};
