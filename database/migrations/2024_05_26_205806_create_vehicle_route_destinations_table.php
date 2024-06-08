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
        Schema::create('vehicle_route_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->cascadeOnUpdate()->nullable();
            $table->foreignId('route_schedule_id')->constrained()->cascadeOnUpdate()->nullable();
            $table->integer('available_seats');
            $table->integer('reserved_seats');
            $table->date('journey_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_route_destinations');
    }
};
