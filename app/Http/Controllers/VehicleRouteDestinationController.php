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
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        $allScheduleDates = VehicleRouteDestination::where('route_schedule_id', $id)->whereBetween('journey_date', [$startOfMonth, $endOfMonth])->select('id', 'journey_date')->orderBy('journey_date', 'asc')->get()->unique('journey_date');

        if($allScheduleDates->isEmpty())
        {
            return response()->json(['message' => 'This journey-route has not been set for travel.'], 404);
        }

        return VehicleRouteDestinationResource::collection($allScheduleDates);
    }

    public function getAllDateScheduleJourneys(Request $request, $routeScheduleId, $journeyDate) 
    {
        $relationships = ['vehicle.vehicleCategory', 'routeSchedule.routeDestination.route'];
        $allScheduleJourneys = VehicleRouteDestination::with($relationships)->where('route_schedule_id', $routeScheduleId)->where('journey_date', 'LIKE', "%{$journeyDate}%")->orderBy('vehicle_route_destinations.available_seats', 'asc')->get();

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

    public function getRecentTravelJourneys(Request $request) 
    {
        $today = Carbon::today()->format('Y-m-d');

        $relationships = ['vehicle.vehicleCategory', 'routeSchedule.routeDestination.route'];

        $allScheduleJourneys = VehicleRouteDestination::with($relationships)
            ->whereDate('journey_date', $today)
            ->get()
            ->filter(function($journey) {
                return $journey->vehicle->vehicleCategory->size > 0;
            })
            ->map(function($journey) {
                $journey->seat_ratio = $journey->available_seats / $journey->vehicle->vehicleCategory->size;
                return $journey;
            })
            ->sortBy('seat_ratio');

        if ($allScheduleJourneys->isEmpty()) {
            return response()->json(['message' => 'Nothing found.'], 404);
        }

        return VehicleRouteDestinationResource::collection($allScheduleJourneys);
    }
}
