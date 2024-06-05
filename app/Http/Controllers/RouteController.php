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
    // Get all
    public function getRouteList($request)
    {
        //
    }
}
