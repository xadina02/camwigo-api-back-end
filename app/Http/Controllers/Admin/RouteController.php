<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\RouteDestination;
use App\Http\Requests\RouteRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\RouteResource;
use App\Http\Requests\UpdateRouteRequest;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        $relationships = ['routeDestinations'];
        $allRoutes = Route::with($relationships)->get();

        $filePath = public_path('storage/texts/towns.txt');

        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);
            $towns = explode("\n", $fileContents);
            $towns = array_map('trim', $towns);
            $towns = array_filter($towns);
        }

        // return response()->json(['routes' => $allRoutes], 200);
        return view('admin.route-journey', compact('allRoutes', 'towns'));
    }

    public function store(RouteRequest $request)
    {
        $validated = $request->validated();

        if ($validated['origin'] === $validated['destination']) {
            return redirect()->route('journey-routes.index')->with('error', 'Origin and Destination cannot be the same');
        }
    
        $journeyRoute = Route::where('origin->en', $validated['origin'])->first();

        if ($journeyRoute) {
            $destinationExist = $journeyRoute->routeDestinations()
                                            ->where('destination->en', $validated['destination'])
                                            ->exists();
            if ($destinationExist) {
                return redirect()->route('journey-routes.index')->with('error', 'This journey route has already been recorded');
            }
        } else {
            $journeyRoute = new Route();
            $journeyRoute->origin = $validated['origin'];
            $journeyRoute->created_at = now();
            $journeyRoute->updated_at = now();
            $journeyRoute->save();
        }
        
        $journeyRouteDestination = new RouteDestination();
        $journeyRouteDestination->route_id = $journeyRoute->id;
        $journeyRouteDestination->destination = $validated['destination'];
        $journeyRouteDestination->price = $validated['price'];
        $journeyRouteDestination->created_at = now();
        $journeyRouteDestination->updated_at = now();
        $journeyRouteDestination->save();

        return redirect()->route('journey-routes.index')->with('success', 'Journey route created successfully');
    }


    public function show($id)
    {
        $relationships = ['routeDestinations.routeSchedules.vehicleRouteDestinations'];
        // $relationships = ['routeDestinations.routeSchedules.vehicleRouteDestinations.vehicle.vehicleCategory'];
        $journeyRoute = Route::with($relationships)->find($id);

        $filePath = public_path('storage/texts/towns.txt');

        if (file_exists($filePath)) {
            $fileContents = file_get_contents($filePath);
            $towns = explode("\n", $fileContents);
            $towns = array_map('trim', $towns);
            $towns = array_filter($towns);
        }

        // return response()->json(['route' => $journeyRoute], 200);
        return view('admin.show-route-journey', compact('journeyRoute', 'towns'));
    }

    public function update(UpdateRouteRequest $request, $id)
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $journeyRoute = Route::find($id);

        if ($journeyRoute) {
            $journeyRoute->update($validated);

            // return response()->json(['message' => 'Journey route updated successfully'], 200);
            return redirect()->route('journey-routes.index')->with('success', 'Journey route updated successfully');
        }

        // return response()->json(['message' => 'Journey route not found'], 404);
        return redirect()->route('journey-routes.index')->with('error', 'Journey route not found');
    }

    public function destroy($id)
    {
        $journeyRoute = Route::find($id);

        if ($journeyRoute) {
            $journeyRoute->delete();

            // return response()->json(['message' => 'Journey route deleted successfully'], 200);
            return redirect()->route('journey-routes.index')->with('success', 'Journey route deleted successfully');
        }
        
        // return response()->json(['message' => 'Journey route not found'], 404);
        return redirect()->route('journey-routes.index')->with('error', 'Journey route not found');
    }
}
