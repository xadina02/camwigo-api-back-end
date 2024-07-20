<?php

namespace App\Http\Controllers\Validator;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    public function index(Request $request, $scheduleId)
    {
        $relationships = ['vehicleCategory'];

        $allVehicles = Vehicle::with($relationships)
            ->whereHas('vehicleRouteDestinations', function ($query) use ($scheduleId) {
                $query->where('route_schedule_id', $scheduleId);
            })
            ->get();

        if ($allVehicles->isEmpty()) {
            return response()->json(['message' => 'No vehicles have been scheduled for at the given schedule.'], 404);
        }

        return VehicleResource::collection($allVehicles);
    }
}
