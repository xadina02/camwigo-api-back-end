<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RouteSchedule;
use App\Models\Route;
use App\Http\Requests\RouteScheduleRequest;
use App\Http\Requests\UpdateRouteScheduleRequest;
use App\Http\Resources\RouteScheduleResource;
use Carbon\Carbon;

class RouteScheduleController extends Controller
{
    public function getRouteSchedules(Request $request, $routeID) 
    {
        $allRouteSchedules = RouteSchedule::where('route_destination_id', $routeID)->get();

        if(!$allRouteSchedules->isEmpty()) {
            return RouteScheduleResource::collection($allRouteSchedules);
        }

        return response()->json(['message' => 'There are no available schedules for this route'], 404);
    }

    public function store(RouteScheduleRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $route = Route::find($validated['route_id']);

        if($route) 
        {
            $routeSchedule = new RouteSchedule();
            $routeSchedule->route_id = $validated['route_destination_id'];
            $routeSchedule->label = $validated['label'];
            $routeSchedule->departure_time = $validated['departure_time'];
            $routeSchedule->created_at = $current_timestamp;
            $routeSchedule->updated_at = $current_timestamp;
            $routeSchedule->save();

            return response()->json(['message' => 'Route schedule set successfully'], 200);
        }

        return response()->json(['message' => 'The journey route does not exist'], 404);
    }

    public function show($id) 
    {
        $relationships = ['routeDestination.route'];
        $schedule = RouteSchedule::find($id)->with($relationships);

        if($schedule) 
        {
            return new RouteScheduleResource($schedule);
        }

        return response()->json(['message' => 'The route schedule does not exist'], 404);
    }

    public function update(UpdateRouteScheduleRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $routeSchedule = RouteSchedule::find($id);

        if ($routeSchedule) {
            $routeSchedule->update($validated);

            return response()->json(['message' => 'Route schedule updated successfully'], 200);
        }

        return response()->json(['message' => 'Route schedule not found'], 404);
    }

    public function destroy($id) 
    {
        $routeSchedule = RouteSchedule::find($id);

        if ($routeSchedule) {
            $routeSchedule->delete();

            return response()->json(['message' => 'Route schedule deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Route schedule not found'], 404);
    }
}
