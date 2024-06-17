<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\RouteSchedule;
use App\Models\RouteDestination;
use App\Models\VehicleRouteDestination;
use App\Http\Requests\VehicleRouteRequest;
use Carbon\Carbon;

class VehicleRouteDestinationController extends Controller
{
    public function showAllJourneySchedules(Request $request) 
    {
        //
    }

    public function show(Request $request, $id) 
    {
        //
    }

    public function attributeRouteToVehicle(VehicleRouteRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $error = null;

        $routeDestination = RouteDestination::find($validated['route_destination_id']);
        $vehicle = Vehicle::find($id);

        if($routeDestination) {
            if($vehicle) {
                foreach($routeDestination->routeSchedules as $routeSchedule) {
                    foreach($validated['dates'] as $date) {
                        $vehicleRouteDestination = VehicleRouteDestination::where('vehicle_id', $id)->where('route_schedule_id', $routeSchedule->id)->where('journey_date', $date)->first();
                        if($vehicleRouteDestination) {
                            $error[] = "A travel journey already exists for the '" . $routeSchedule->label . "' schedule of this journey route for the day " . $date;
                            // return redirect()->route('vehicles.show', $id)->with('error', 'Journey route already set');
                            break;
                        } 
                        else {
                            $vehicleRouteDest = new VehicleRouteDestination();
                            $vehicleRouteDest->vehicle_id = $id;
                            $vehicleRouteDest->route_schedule_id = $routeSchedule->id;
                            $vehicleRouteDest->available_seats = $vehicle->vehicleCategory->size;
                            $vehicleRouteDest->reserved_seats = 0;
                            $vehicleRouteDest->journey_date = $date;
                            $vehicleRouteDest->created_at = $current_timestamp;
                            $vehicleRouteDest->updated_at = $current_timestamp;
                            $vehicleRouteDest->save();
                        }
                    }
                }

                if($error == null) 
                {
                    // return response()->json(['message' => 'Vehicle route set successfully'], 200);
                    return redirect()->route('vehicles.show', $id)->with('success', 'Vehicle route set successfully');
                }
                else {
                    $errorMessages = [];
                    foreach ($error as $err) {
                        $errorMessages[] = $err;
                    }
                    
                    // Flash error messages to the session under 'errors' key
                    return redirect()->route('vehicles.show', $id)->withErrors($errorMessages);
                }
            }

            // return response()->json(['message' => 'Vehicle not found'], 404);
            return redirect()->route('vehicles.show', $id)->with('error', 'Vehicle not found');
        }

        // return response()->json(['message' => 'Journey route not found'], 404);
        return redirect()->route('vehicles.show', $id)->with('error', 'Journey route not found');
    }

    public function destroy($id) 
    {
        $vehicleRouteDestination = VehicleRouteDestination::find($id);

        if ($vehicleRouteDestination) {
            $vehicleRouteDestination->delete();

            // return response()->json(['message' => 'Vehicle journey deleted successfully'], 200);
            return redirect()->route('vehicles.show', $vehicleRouteDestination->vehicle->id)->with('success', 'Vehicle journey deleted successfully');
        }
        
        // return response()->json(['message' => 'Vehicle journey not found'], 404);
        return redirect()->route('vehicles.show', $vehicleRouteDestination->vehicle->id)->with('error', 'Vehicle journey not found');
    }
}
