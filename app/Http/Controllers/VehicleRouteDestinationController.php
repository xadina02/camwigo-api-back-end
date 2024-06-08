<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\RouteSchedule;
use App\Models\VehicleRouteDestination;
use App\Http\Requests\VehicleRouteRequest;
use Carbon\Carbon;
use App\Http\Resources\VehicleRouteDestinationResource;

class VehicleRouteDestinationController extends Controller
{
    public function getAllScheduleJourneyDates(Request $request, $id) 
    {
        $allScheduleDates = VehicleRouteDestination::where('route_schedule_id', $id)->select('id', 'journey_date')->orderBy('vehicle_route_destinations.date', 'asc')->get();

        if($allScheduleDates->isEmpty())
        {
            return response()->json(['message' => 'This journey-route has not been set for travel.'], 404);
        }

        return VehicleRouteDestinationResource::collection($allScheduleDates);
    }

    public function getAllDateScheduleJourneys(Request $request) 
    {
        $scheduleID = $request->input('route_schedule');
        $date = $request->input('journey_date');
        $relationships = ['vehicle.vehicleCategory', 'routeSchedule.routeDestination'];
        $allScheduleJourneys = VehicleRouteDestination::with($relationships)->where('route_schedule_id', $scheduleID)->where('journey_date', 'LIKE', "%{$date}%")->orderBy('vehicle_route_destinations.available_seats', 'asc')->get();

        if($allScheduleJourneys->isEmpty())
        {
            return response()->json(['message' => 'Nothing found.'], 404);
        }

        return VehicleRouteDestinationResource::collection($allScheduleJourneys);
    }

    public function getScheduleJourneyDetails(Request $request, $id) 
    {
        $relationships = ['vehicle.vehicleCategory', 'routeSchedule.routeDestination.route', 'reservations'];
        $scheduleJourney = VehicleRouteDestination::with($relationships)->find($id);

        if(!$scheduleJourney)
        {
            return response()->json(['message' => 'Nothing found.'], 404);
        }

        return new VehicleRouteDestinationResource($scheduleJourney);
    }
}
