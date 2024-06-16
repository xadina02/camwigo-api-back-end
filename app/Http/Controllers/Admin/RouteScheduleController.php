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

            // return response()->json(['message' => 'Route schedule set successfully'], 200);
            return redirect()->route('journey-routes.show', ['journey_route' => $routeDestination->route->id])->with('success', 'Route schedule set successfully');
        }

        // return response()->json(['message' => 'The route destination does not exist'], 404);
        return redirect()->route('journey-routes.show', ['journey_route' => $routeDestination->route->id])->with('error', 'The route destination does not exist');
    }

    public function update(UpdateRouteScheduleRequest $request, $id) 
    {
        logger("Edit Schedule Request ", $request->all());
        $validated = $request->validated();
        logger("Edit Schedule Validated fields ", $validated);

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $routeSchedule = RouteSchedule::find($id);

        if ($routeSchedule) {
            logger("Route Schedule found ");
            logger("Updating... ");
            $routeSchedule->update($validated);
            logger("DONE! ");

            // return response()->json(['message' => 'Route schedule updated successfully'], 200);
            return redirect()->route('journey-routes.show', ['journey_route' => $routeSchedule->routeDestination->route->id])->with('success', 'Route schedule updated successfully');
        }
        logger("Route Schedule NOT found ");

        // return response()->json(['message' => 'Route schedule not found'], 404);
        return redirect()->route('journey-routes.show', ['journey_route' => $routeSchedule->routeDestination->route->id])->with('error', 'Route schedule not found');
    }

    public function destroy($id) 
    {
        $routeSchedule = RouteSchedule::find($id);

        if ($routeSchedule) {
            $routeSchedule->delete();

            // return response()->json(['message' => 'Route schedule deleted successfully'], 200);
            return redirect()->route('journey-routes.show', ['journey_route' => $routeSchedule->routeDestination->route->id])->with('success', 'Route schedule deleted successfully');
        }
        
        // return response()->json(['message' => 'Route schedule not found'], 404);
        return redirect()->route('journey-routes.show', ['journey_route' => $routeSchedule->routeDestination->route->id])->with('error', 'Route schedule not found');
    }
}
