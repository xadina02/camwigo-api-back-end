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
        $allTables = [
            'users',
            'routes',
            'route_schedules',
            'vehicles',
            'reservations',
            'tickets',
            'vehicle_categories',
            'route_destinations',
            'vehicle_route_destinations'
        ];

        foreach($allTables as $aTable) 
        {
            Schema::table($aTable, function (Blueprint $table) {
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
