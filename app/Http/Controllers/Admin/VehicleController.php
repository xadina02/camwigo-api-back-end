<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleCategory;
use App\Models\RouteDestination;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Http\Requests\UpdateVehicleRequest;

class VehicleController extends Controller
{
    public function index(Request $request) 
    {
        // $relationships = ['vehicleRouteDestinations.routeSchedule.routeDestination.route', 'vehicleCategory'];
        // $allVehicles = Vehicle::with($relationships)->get();
        $allVehicles = Vehicle::all();
        $allVehicleCategories = VehicleCategory::all();

        // return response()->json(['vehicles' => $allVehicles], 200);
        return view('admin.vehicle', compact('allVehicles', 'allVehicleCategories'));
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

            // return response()->json(['message' => 'Vehicle created successfully'], 200);
            return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
        }

        // return response()->json(['message' => 'The vehicle does not exist'], 404);
        return redirect()->route('vehicles.index')->with('error', 'Vehicle created successfully.');
    }

    public function show($id) 
    {
        // $relationships = ['vehicleRouteDestinations.routeSchedule.routeDestination.route', 'vehicleCategory'];
        // $vehicle = Vehicle::with($relationships)->find($id);
        $vehicle = Vehicle::find($id);

        $allRouteDestinations = RouteDestination::with('route')->get();
    
        $attributedRouteDestinationIds = $vehicle->vehicleRouteDestinations->pluck('route_destination_id')->toArray();
        
        $unattributedRouteDestinations = $allRouteDestinations->filter(function ($routeDestination) use ($attributedRouteDestinationIds) {
            return !in_array($routeDestination->id, $attributedRouteDestinationIds);
        });

        // return response()->json(['vehicle' => $vehicle], 200);
        return view('admin.vehicle-booking', compact('vehicle', 'unattributedRouteDestinations'));
    }

    public function update(UpdateVehicleRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            $vehicle->update($validated);

            // return response()->json(['message' => 'Vehicle details updated successfully'], 200);
            return redirect()->route('vehicles.index')->with('success', 'Vehicle details updated successfully');
        }

        // return response()->json(['message' => 'Vehicle not found'], 404);
        return redirect()->route('vehicles.index')->with('error', 'Vehicle not found');
    }

    public function destroy($id) 
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            $vehicle->delete();

            // return response()->json(['message' => 'Vehicle deleted successfully'], 200);
            return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully');
        }
        
        // return response()->json(['message' => 'Vehicle not found'], 404);
        return redirect()->route('vehicles.index')->with('error', 'Vehicle not found');
    }
}
