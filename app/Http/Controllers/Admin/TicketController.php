<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class TicketController extends Controller
{
    public function index(Request $request) 
    {
        $relationships = ['reservation.user', 'reservation.vehicleRouteDestination.vehicle', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route'];
        $allTickets = Ticket::with($relationships)->get();

        return response()->json(['tickets' => $allTickets], 200);
    }

    public function show($id) 
    {
        $relationships = ['reservation.user', 'reservation.vehicleRouteDestination.vehicle.vehicleCategory', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route'];
        $ticket = Ticket::with($relationships)->find($id);

        return response()->json(['ticket' => $ticket], 200);
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
