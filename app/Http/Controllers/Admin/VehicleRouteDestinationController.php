<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\RouteSchedule;
use App\Models\VehicleRouteDestination;
use App\Http\Requests\VehicleRouteRequest;
use Carbon\Carbon;

class VehicleRouteDestinationController extends Controller
{
    public function attributeRouteToVehicle(VehicleRouteRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $route = RouteSchedule::find($validated['route_schedule_id']);
        $vehicle = Vehicle::find($id);

        if($route) {
            if($vehicle) {
                foreach($validated['dates'] as $date) {
                    $vehicleRouteDest = new VehicleRouteDestination();
                    $vehicleRouteDest->vehicle_id = $id;
                    $vehicleRouteDest->route_schedule_id = $validated['route_schedule_id'];
                    $vehicleRouteDest->available_seats = $vehicle->vehicleCategory->size;
                    $vehicleRouteDest->reserved_seats = 0;
                    $vehicleRouteDest->date = $date;
                    $vehicleRouteDest->created_at = $current_timestamp;
                    $vehicleRouteDest->updated_at = $current_timestamp;
                    $vehicleRouteDest->save();
                }

                return response()->json(['message' => 'Vehicle route set successfully'], 200);
            }

            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        return response()->json(['message' => 'Journey route not found'], 404);
    }

    public function removeRouteFromVehicle($id) 
    {
        $vehicleRouteDest = VehicleRouteDestination::find($id);

        if ($vehicleRouteDest) {
            $vehicleRouteDest->delete();

            return response()->json(['message' => 'Vehicle journey deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Vehicle journey not found'], 404);
    }
}
