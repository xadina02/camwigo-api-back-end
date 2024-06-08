<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouteSchedule;
use App\Models\Route;
use App\Http\Requests\RouteScheduleRequest;
use App\Http\Requests\UpdateRouteScheduleRequest;
use App\Http\Resources\RouteScheduleResource;
use Carbon\Carbon;

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
