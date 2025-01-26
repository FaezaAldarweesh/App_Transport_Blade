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
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('path_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(0);
            $table->time('time_arrive')->default('00:00:00');
            $table->decimal('latitude', 10, 8); // خط العرض
            $table->decimal('longitude', 11, 8); // خط الطول
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
