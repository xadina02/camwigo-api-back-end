<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\RouteDestination;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function getHomePage(Request $request) 
    {
        // Gather stuff here before returning with it
        $numVehicles = Vehicle::count();
        $numRoutes = RouteDestination::count();
        $numReservations = Reservation::count();
        $numUsers = User::count();

        // $latestReservations = Reservation::all();
        $latestReservations = Reservation::where('created_at', '>=', Carbon::now()->subDay())->get();

        // $latestUsers = User::all();
        $latestUsers = User::where('created_at', '>=', Carbon::now()->subDay())->get();
        
        return view('admin.index', compact(['numVehicles', 'numRoutes', 'numReservations', 'numUsers', 'latestReservations', 'latestUsers']));
    }
}
