<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketValidationRequest;
use App\Models\Ticket;
use App\Models\User;
use App\Http\Resources\TicketResource;
use App\Models\VehicleRouteDestination;
use App\Models\Reservation;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function validateTicket(TicketValidationRequest $request)
    {
        $validatedData = $request->validated();
        $relationships = ['reservation.vehicleRouteDestination.vehicle.vehicleCategory', 'reservation.reservationPositions', 'reservation.vehicleRouteDestination.routeSchedule.routeDestination.route', 'reservation.user'];

        // return new TicketResource(Ticket::with($relationships)->find(6));
        // return response()->json(['message' => 'Tickets validation failed'], 404);

        $journey = VehicleRouteDestination::where('vehicle_id', $validatedData['vehicle_id'])->where('route_schedule_id', $validatedData['route_schedule_id'])->where('journey_date', $validatedData['date'])->first();

        if ($journey) {
            $ticketData = json_decode((base64_decode($validatedData['ticket_data'])));

            if (isset($ticketData['user_id'])) {
                $reservation = Reservation::where('vehicle_route_destination_id', $journey->id)->where('user_id', $ticketData['user_id'])->first();

                if ($reservation) {
                    $retrievedTicket = Ticket::where('reservation_id', $reservation->id)->where('id', $ticketData['ticket_id'])->with($relationships)->first();

                    if (!$retrievedTicket) {
                        return response()->json(['message' => 'Ticket not validated'], 404);
                    }

                    return new TicketResource($retrievedTicket);
                }

                return response()->json(['message' => 'Reservation not found'], 404);
            }

            return response()->json(['message' => 'User not identified'], 404);
        }

        return response()->json(['message' => 'Trip not found'], 404);
    }
}
