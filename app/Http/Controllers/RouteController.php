<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\RouteDestination;
use App\Http\Requests\RouteRequest;
use App\Http\Requests\UpdateRouteRequest;
use App\Http\Resources\RouteResource;
use Carbon\Carbon;

class RouteController extends Controller
{
    public function getAllRoutes(Request $request)
    {
        $allRoutes = Route::select('id', 'origin')->get();

        if($allRoutes->isEmpty())
        {
            return response()->json(['message' => 'No available routes yet.'], 404);
        }

        return RouteResource::collection($allRoutes);
    }

    public function searchRoutes(Request $request)
    {
        $searchQuery = strtolower($request->input('search_text'));

        $allRoutes = Route::where(function ($query) use ($searchQuery) {
            $query->whereRaw('LOWER(origin) LIKE ?', ["%{$searchQuery}%"]);
        })
        ->select('id', 'origin')
        ->orderBy('routes.origin', 'asc')
        ->get();
        
        if($allRoutes->isEmpty())
        {
            return response()->json(['message' => 'Nothing found.'], 404);
        }
        return RouteResource::collection($allRoutes);
    }
}
