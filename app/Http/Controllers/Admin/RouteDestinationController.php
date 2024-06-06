<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\RouteDestination;
use App\Http\Requests\RouteDestinationRequest;
use App\Http\Requests\UpdateRouteDestinationRequest;
use App\Http\Resources\RouteDestinationResource;
use Carbon\Carbon;

class RouteDestinationController extends Controller
{
    public function update(UpdateRouteDestinationRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $routeDestination = RouteDestination::find($id);

        if ($routeDestination) {
            $routeDestination->update($validated);

            return response()->json(['message' => 'Route destination updated successfully'], 200);
        }

        return response()->json(['message' => 'Route destination not found'], 404);
    }

    public function destroy($id) 
    {
        $routeDestination = RouteDestination::find($id);

        if ($routeDestination) {
            $routeDestination->delete();

            return response()->json(['message' => 'Route destination deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Route destination not found'], 404);
    }
}
