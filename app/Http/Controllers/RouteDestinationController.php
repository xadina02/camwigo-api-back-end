<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\RouteDestination;
use App\Http\Requests\RouteDestinationRequest;
use App\Http\Requests\UpdateRouteDestinationRequest;
use App\Http\Resources\RouteDestinationResource;
use Carbon\Carbon;

class RouteDestinationController extends Controller
{
    public function getRouteDestinationList(Request $request, $id) 
    {
        $allRouteDestinations = RouteDestination::where('route_id', $id)->select('id', 'destination')->get();

        if($allRouteDestinations->isEmpty())
        {
            return response()->json(['message' => 'There are no current destinations to this route.'], 404);
        }

        return RouteDestinationResource::collection($allRouteDestinations);
    }

    public function searchRouteDestinations(Request $request, $id)
    {
        $searchQuery = strtolower($request->input('search_text'));

        $allRouteDestinations = RouteDestination::where('route_id', $id)->where(function ($query) use ($searchQuery) {
            $query->whereRaw('LOWER(destination) LIKE ?', ["%{$searchQuery}%"]);
        })
        ->select('id', 'destination')
        ->orderBy('route_destinations.destination', 'asc')
        ->get();
        
        if($allRouteDestinations->isEmpty())
        {
            return response()->json(['message' => 'Nothing found.'], 404);
        }

        return RouteDestinationResource::collection($allRouteDestinations);
    }
}
