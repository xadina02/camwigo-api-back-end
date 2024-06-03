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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_schedule_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_destination_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('QR_code_image_link')->nullable();
            $table->enum('status', ['new', 'used'])->default('new');
            $table->timestamp('validity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
