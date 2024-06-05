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
    // For a particular route
    public function getRouteDestinationList() 
    {
        //
    }
}
