<?php

namespace App\Http\Controllers\Validator;

use Illuminate\Http\Request;
use App\Models\RouteSchedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\RouteScheduleResource;

class RouteScheduleController extends Controller
{
    public function getRouteSchedules(Request $request, $id) 
    {
        $allRouteSchedules = RouteSchedule::where('route_destination_id', $id)->select('id', 'label', 'departure_time')->orderBy('route_schedules.departure_time', 'asc')->get();

        if($allRouteSchedules->isEmpty())
        {
            return response()->json(['message' => 'This route has not been scheduled for travel.'], 404);
        }

        return RouteScheduleResource::collection($allRouteSchedules);
    }
}
