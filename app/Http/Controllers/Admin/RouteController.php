<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\RouteDestination;
use App\Http\Requests\RouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Resources\RouteResource;
use Carbon\Carbon;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $relationships = ['routeDestinations'];
        $allRoutes = Route::with($relationships)->get();

        return response()->json(['routes' => $allRoutes], 200);
    }

    public function store(RouteRequest $request)
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $journeyRoute = new Route();
        $journeyRoute->origin = $validated['origin'];
        $journeyRoute->created_at = $current_timestamp;
        $journeyRoute->updated_at = $current_timestamp;

        if($journeyRoute->save()) 
        {
            $destinations = $validated['destinations'];

            foreach ($destinations as $destination) 
            {
                $journeyRouteDestinations = new RouteDestination();
                $journeyRouteDestinations->route_id = $journeyRoute->id;
                $journeyRouteDestinations->destination = $destination;
                $journeyRouteDestinations->save();
            }

            return response()->json(['message' => 'Journey route created successfully'], 200);
        }
    }

    public function show($id)
    {
        $relationships = ['routeDestinations.routeSchedules.vehicleRouteDestinations.vehicle.vehicleCategory'];
        $journeyRoute = Route::with($relationships)->find($id);

        return response()->json(['route' => $journeyRoute], 200);
    }

    public function update(UpdateRouteRequest $request, $id)
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $journeyRoute = Route::find($id);

        if ($journeyRoute) {
            $journeyRoute->update($validated);

            return response()->json(['message' => 'Journey route updated successfully'], 200);
        }

        return response()->json(['message' => 'Journey route not found'], 404);
    }

    public function destroy($id)
    {
        $journeyRoute = Route::find($id);

        if ($journeyRoute) {
            $journeyRoute->delete();

            return response()->json(['message' => 'Journey route deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Journey route not found'], 404);
    }
}
