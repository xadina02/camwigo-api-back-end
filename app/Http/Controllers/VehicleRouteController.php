<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Route;
use App\Http\Requests\VehicleRouteRequest;
use Carbon\Carbon;

class VehicleRouteController extends Controller
{
    public function attributeRouteToVehicle(VehicleRouteRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $route = Route::find($validated['route_id']);
        $vehicle = Vehicle::find($id);

        if($route) {
            if($vehicle) {
                $validated['updated_at'] = $current_timestamp;
                $vehicle->update($validated);

                return response()->json(['message' => 'Vehicle route set successfully'], 200);
            }

            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        return response()->json(['message' => 'Journey route not found'], 404);
    }
}
