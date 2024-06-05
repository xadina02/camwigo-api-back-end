<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouteSchedule;
use App\Models\Route;
use App\Http\Requests\RouteScheduleRequest;
use App\Http\Requests\UpdateRouteScheduleRequest;
use App\Http\Resources\RouteScheduleResource;
use Carbon\Carbon;

class RouteScheduleController extends Controller
{
    public function getRouteSchedulesList(Request $request, $route_destination) 
    {
        //
    }
}
