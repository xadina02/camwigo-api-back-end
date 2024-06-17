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
        $query = VehicleRouteDestination::query();

        if ($request->filled('vehicle_name')) {
            $query->whereHas('vehicle', function($q) use ($request) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->vehicle_name) . '%']);
            });
        }
    
        if ($request->filled('route_origin')) {
            $query->whereHas('routeSchedule.routeDestination.route', function($q) use ($request) {
                $q->whereRaw('LOWER(origin) LIKE ?', ['%' . strtolower($request->route_origin) . '%']);
            });
        }
    
        if ($request->filled('route_destination')) {
            $query->whereHas('routeSchedule.routeDestination', function($q) use ($request) {
                $q->whereRaw('LOWER(destination) LIKE ?', ['%' . strtolower($request->route_destination) . '%']);
            });
        }
    
        if ($request->filled('route_schedule_label')) {
            $query->whereHas('routeSchedule', function($q) use ($request) {
                $q->whereRaw('LOWER(label) LIKE ?', ['%' . strtolower($request->route_schedule_label) . '%']);
            });
        }

        if ($request->filled('route_schedule_time')) {
            $query->whereHas('routeSchedule', function($q) use ($request) {
                $q->whereTime('departure_time', $request->route_schedule_time);
            });
        }

        if ($request->filled('journey_date')) {
            $query->whereDate('journey_date', $request->journey_date);
        }

        $travelJourneys = $query->get();

        // Format data for DataTable
        $data = $travelJourneys->map(function($journey) {
            return [
                $journey->vehicle->name,
                $journey->vehicle->vehicleCategory->name,
                $journey->routeSchedule->routeDestination->route->origin,
                $journey->routeSchedule->routeDestination->destination,
                $journey->routeSchedule->label,
                \Carbon\Carbon::parse($journey->routeSchedule->departure_time)->format('h:i A'),
                $journey->available_seats,
                $journey->reservations->count(),
                \Carbon\Carbon::parse($journey->journey_date)->format('d M Y'),
                '<button type="button" class="btn btn-danger delete-button" data-id="' . $journey->id . '" data-url="' . route('vehicles-route-destinations.destroy', $journey->id) . '">Delete</button>'
            ];
        });

        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }

        return view('admin.travel-journey', compact('travelJourneys'));
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
            return redirect()->back()->with('success', 'Vehicle journey deleted successfully');
        }
        
        // return response()->json(['message' => 'Vehicle journey not found'], 404);
        return redirect()->back()->with('error', 'Vehicle journey not found');
    }
}
