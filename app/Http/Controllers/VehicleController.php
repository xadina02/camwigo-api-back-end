<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\Route;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use Carbon\Carbon;

class VehicleController extends Controller
{
    public function getRouteVehicleList(Request $request, $routeID) 
    {
        $allRouteVehicles = Vehicle::where('route_id', $routeID)->get();

        if(!$allRouteVehicles->isEmpty()) {
            return VehicleResource::collection($allRouteVehicles);
        }

        return response()->json(['message' => 'There are no available vehicles for this route'], 404);
    }

    public function show($id) 
    {
        $relationships = ['route.routeSchedules', 'route.routeDestinations', 'vehicleCategory', 'reservations.user'];
        $vehicle = Vehicle::find($id)->with($relationships);

        if(!$vehicle->isEmpty()) {
            return new VehicleResource($vehicle);
        }

        return response()->json(['message' => 'Vehicle not found'], 404);
    }
}
