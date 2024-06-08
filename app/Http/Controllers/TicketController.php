<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reservation;
use App\Models\User;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class TicketController extends Controller
{
    public function show($id) 
    {
        $reservation = Reservation::find($id);

        if($reservation) 
        {
            $relationships = ['reservation.vehicleRouteDestination.vehicle.vehicleCategory', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route'];
            $ticket = Ticket::with($relationships)->where('reservation_id', $id)->get();

            if($ticket) {
                return new TicketResource($ticket);
            }

            return response()->json(['message' => 'Ticket not available'], 404);
        }

        return response()->json(['message' => 'Reservation not found'], 404);
    }
}
