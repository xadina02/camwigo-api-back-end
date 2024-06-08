<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\RouteSchedule;
use App\Models\RouteDestination;
use App\Http\Controllers\Controller;
use App\Http\Requests\RouteScheduleRequest;
use App\Http\Resources\RouteScheduleResource;
use App\Http\Requests\UpdateRouteScheduleRequest;

class RouteScheduleController extends Controller
{
    public function store(RouteScheduleRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $routeDestination = RouteDestination::find($validated['route_destination_id']);

        if($routeDestination) 
        {
            $routeSchedule = new RouteSchedule();
            $routeSchedule->route_destination_id = $validated['route_destination_id'];
            $routeSchedule->label = $validated['label'];
            $routeSchedule->departure_time = $validated['departure_time'];
            $routeSchedule->created_at = $current_timestamp;
            $routeSchedule->updated_at = $current_timestamp;
            $routeSchedule->save();

            return response()->json(['message' => 'Route schedule set successfully'], 200);
        }

        return response()->json(['message' => 'The route destination does not exist'], 404);
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
