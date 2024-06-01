<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Ticket;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class TicketController extends Controller
{
    public function index(Request $request) 
    {
        $relationships = ['reservation.user', 'reservation.vehicle.vehicleCategory', 'routeSchedule', 'routeDestination.route'];
        $allTickets = Ticket::all()->with($relationships);

        if(!$allTickets->isEmpty()) {
            return TicketResource::collection($allTickets);
        }

        return response()->json(['message' => 'There are no available tickets'], 404);
    }

    public function show($id) 
    {
        $relationships = ['reservation.user', 'reservation.vehicle.vehicleCategory', 'routeSchedule', 'routeDestination.route'];
        $ticket = Ticket::find($id)->with($relationships);

        if(!$ticket->isEmpty()) {
            return new TicketResource($ticket);
        }

        return response()->json(['message' => 'Vehicle not found'], 404);
    }

    public function destroy($id) 
    {
        $ticket = Ticket::find($id);

        if ($ticket) {
            ImageHelper::handleImageDelete($ticket->QR_code_image_link);
            $ticket->delete();

            return response()->json(['message' => 'Ticket deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Ticket not found'], 404);
    }
}
