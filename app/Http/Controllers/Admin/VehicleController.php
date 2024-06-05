<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function index(Request $request) 
    {
        $relationships = ['vehicleCategory'];
        $allVehicles = Vehicle::all()->with($relationships);

        if(!$allVehicles->isEmpty()) {
            return VehicleResource::collection($allVehicles);
        }

        return response()->json(['message' => 'There are no available vehicles'], 404);
    }

    public function store(VehicleRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $vehicleCategory = VehicleCategory::find($validated['vehicle_category_id']);

        if($vehicleCategory) {
            $vehicle = new Vehicle();
            $vehicle->vehicle_category_id = $validated['vehicle_category_id'];
            $vehicle->name = $validated['name'];
            $vehicle->created_at = $current_timestamp;
            $vehicle->updated_at = $current_timestamp;
            $vehicle->save();

            return response()->json(['message' => 'Vehicle created successfully'], 200);
        }

        return response()->json(['message' => 'The vehicle category does not exist'], 404);
    }

    public function show($id) 
    {
        $relationships = ['vehicleRouteDestinations.routeSchedule.routeDestination.route' ,'vehicleCategory'];
        $vehicle = Vehicle::find($id)->with($relationships);

        if(!$vehicle->isEmpty()) {
            return new VehicleResource($vehicle);
        }

        return response()->json(['message' => 'Vehicle not found'], 404);
    }

    public function update(UpdateVehicleRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            $vehicle->update($validated);

            return response()->json(['message' => 'Vehicle details updated successfully'], 200);
        }

        return response()->json(['message' => 'Vehicle not found'], 404);
    }

    public function destroy($id) 
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            $vehicle->delete();

            return response()->json(['message' => 'Vehicle deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Vehicle not found'], 404);
    }
}
