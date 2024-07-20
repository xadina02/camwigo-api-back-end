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
    public function index(Request $request)
    {
        $userId = auth('sanctum')->user()->id;
        $user = User::find($userId);

        $relationships = ['reservation.vehicleRouteDestination.vehicle.vehicleCategory', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route'];
        $tickets = Ticket::whereHas('reservation', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with($relationships)->orderBy('updated_at', 'desc')->get();

        if ($tickets) {
            return TicketResource::collection($tickets);
        }

        return response()->json(['message' => 'Tickets not available'], 404);
    }

    public function show(Request $request, $id)
    {
        $userId = auth('sanctum')->user()->id;
        $user = User::find($userId);

        $relationships = ['reservation.vehicleRouteDestination.vehicle.vehicleCategory', 'reservation.reservationPositions', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route'];
        $ticket = Ticket::with($relationships)->find($id);

        if ($ticket) {
            return new TicketResource($ticket);
        }

        return response()->json(['message' => 'Ticket not available'], 404);
    }
}
