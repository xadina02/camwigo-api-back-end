<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketValidationRequest;
use App\Models\Ticket;
use App\Models\VehicleRouteDestination;
use App\Models\Reservation;
use Carbon\Carbon;

class ValidationController extends Controller
{
    public function validateTicket(TicketValidationRequest $request)
    {
        $validatedData = $request->validated();

        $journey = VehicleRouteDestination::where('vehicle_id', $validatedData['vehicle_id'])->where('route_schedule_id', $validatedData['route_schedule_id'])->where('journey_date', $validatedData['date'])->first();

        if ($journey) 
        {
            dd(base64_decode($validatedData['ticket_data']));
            $reservation = Reservation::where('vehicle_route_destination_id', $journey->id)->first();

            if($reservation) 
            {
                $retrievedTicket = Ticket::where('reservation_id', $reservation->id)->first();
            }
        }
        //$ticket = base64_decode($validatedData['ticket_data']')
    }
}
