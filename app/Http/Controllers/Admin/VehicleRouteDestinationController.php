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
        logger("In the route attribution method ", [$request->all()]);
        $validated = $request->validated();
        logger("Validated fields ", $validated);

        $current_timestamp = Carbon::now();
        $error = null;

        $routeDestination = RouteDestination::find($validated['route_destination_id']);
        $vehicle = Vehicle::find($id);

        if($routeDestination) {
            logger("The route destination exists", [$routeDestination]);

            if($vehicle) {
            logger("The vehicle exists", []);
            
                foreach($routeDestination->routeSchedules as $routeSchedule) {
                    logger("Going over each schedule for that journey", []);

                    foreach($validated['dates'] as $date) {
                        $vehicleRouteDestination = VehicleRouteDestination::where('vehicle_id', $id)->where('route_schedule_id', $routeSchedule->id)->where('journey_date', $date)->first();
                        if($vehicleRouteDestination) {
                            logger("The schedule of id " . $routeSchedule->id . " already has a record on this model for that vehicle!!", []);
                            $error[] = "A travel journey already exists for the '" . $routeSchedule->label . "' schedule of this journey route for the day " . $date;
                            // return redirect()->route('vehicles.show', $id)->with('error', 'Journey route already set');
                            break;
                        } 
                        else {
                            logger("Creating a record on this model for this vehicle, for the schedule of id" . $routeSchedule->id, []);
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

    // public function removeRouteFromVehicle($id) 
    // {
    //     $vehicleRouteDest = VehicleRouteDestination::find($id);

    //     if ($vehicleRouteDest) {
    //         $vehicleRouteDest->delete();

    //         // return response()->json(['message' => 'Vehicle journey deleted successfully'], 200);
    //         return redirect()->route('vehicles.show', $id)->with('success', 'Vehicle journey deleted successfully');
    //     }
        
    //     // return response()->json(['message' => 'Vehicle journey not found'], 404);
    //     return redirect()->route('vehicles.show', $id)->with('error', 'Vehicle journey not found');
    // }

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
