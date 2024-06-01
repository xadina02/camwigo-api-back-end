<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Ticket;
use App\models\Reservation;
use App\models\RouteSchedule;
use App\models\RouteDestination;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TicketRequest;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function handlePayment(TicketRequest $request)
    {
        /**
         * Handle Payment
         * 
         * Generate and return ticket details using generateTicket($request)
         * 
         * Generate, save and return the link to the QR-Code, using generateQrCode($ticket) - with the use of the ticket details gotten above
         * 
         * Assign the QR-Code image file path, returned above to the value of the QR_code_image_link attribute of the $ticket instance and then save the ticket record
         * 
         * Return return response()->json(['message' => 'Payment successful!'], 200);
         */
    }

    public function generateTicket(TicketRequest $request): Ticket
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        // Logic to calculate and get validity period as $validity_timestamp

        $reservation = Reservation::find($validated['reservation_id']);
        $routeSchedule = RouteSchedule::find($validated['route_schedule_id']);
        $routeDestination = RouteDestination::find($validated['route_destination_id']);

        if($routeDestination) {
            if($routeSchedule) {
                if($reservation) {
                    $ticket = new Ticket();
                    $ticket->reservation_id = $validated['reservation_id'];
                    $ticket->reservation_id = $validated['route_schedule_id'];
                    $ticket->route_destination_id = $validated['route_destination_id'];
                    $ticket->status = "new";
                    // $ticket->validity = $validity_timestamp;
                    $ticket->created_at = $current_timestamp;
                    $ticket->updated_at = $current_timestamp;

                    return $ticket;
                }
            }
        }
    }

    public function generateQrCode(Ticket $ticket) 
    {
        /**
         * Generate QR code as image
         * 
         * Upload QR-Code image and return the link to the uploaded image - using handleImageUpload()
         */
    }

    public function handleImageUpload(TicketRequest $request)
    {
        $folder = 'ticket-qr-codes';
        $imageLink = '/images/defaultIcon.svg';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $storagePath = 'public/images/' . $folder . '/';

            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }

            $image->storeAs($storagePath, $imageName);

            $imageLink = '/images/' . $folder . '/' . $imageName;
        }

        return $imageLink;
    }
}
