<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Http\Requests\RouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Resources\RouteResource;
use Carbon\Carbon;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $allRoutes = Route::all();

        if(!$allRoutes->isEmpty()) {
            return RouteResource::collection($allRoutes);
        }

        return response()->json(['message' => 'There are no available journey routes'], 404);
    }

    public function store(RouteRequest $request)
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $journeyRoute = new Route();
        $journeyRoute->origin = $validated['origin'];
        $journeyRoute->destination = $validated['destination'];
        $journeyRoute->created_at = $current_timestamp;
        $journeyRoute->updated_at = $current_timestamp;
        $journeyRoute->save();

        return response()->json(['message' => 'Journey route created successfully'], 200);
    }

    public function show($id)
    {
        $journeyRoute = Route::find($id);

        if ($journeyRoute) {
            return new RouteResource($journeyRoute);
        }

        return response()->json(['message' => 'Journey route not found'], 404);
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
