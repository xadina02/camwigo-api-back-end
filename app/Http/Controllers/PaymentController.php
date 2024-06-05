<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reservation;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TicketRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function handleGet()
    {
        return view('real-payment');
    }

    /**
     * Handle Payment
     */
    public function handlePayment(TicketRequest $request, $reservation_id)
    {
        $validated = $request->validated();

        $reservation = Reservation::find($reservation_id);

        // For testing - To Be Removed!
        $amount = $validated['amount'];
        // $amount = $reservation->vehicleRouteDestination->price;

        /*
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => 1000, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Test payment from Laravel app',
        ]);
        */

        $reservation->amount_paid += $amount;
        $reservation->save();

        // After successful payment, set $reservation->status = "paid" if `amount` == $reservation->vehicleRouteDestination->price | To show the reservation has been paid for but not yet completed (status = "complete" - where ticket and qr code have been generated and saved)
        // After successful payment, set $reservation->status = "partial" if `amount` < $reservation->vehicleRouteDestination->price | To show the reservation has been paid for but not yet completed (status = "complete" - where ticket and qr code have been generated and saved)

        if($reservation->amount_paid == $reservation->vehicleRouteDestination->price) 
        {
            $ticket = $this->generateTicket($reservation_id);
            
            if($ticket != null) {
                $qr_code_link = $this->generateQrCode($ticket);

                $ticket->QR_code_image_link = $qr_code_link;
                $ticket->save();

                $reservation->status = "completed";
                $reservation->save();

                return response()->json(['message' => 'Payment successful! Reservation created!'], 200);
            }
        }
    }

    public function generateTicket($id): Ticket
    {
        $reservation = Reservation::find($id);

        $current_timestamp = Carbon::now();
        $validity_timestamp = Carbon::now()->format('Y-m-d') . ' ' . Carbon::parse($reservation->vehicleRouteDestination->routeSchedule->departure_time)->addMinutes(15)->format('H:i:s');

        if($reservation) {
            $ticket = new Ticket();
            $ticket->reservation_id = $id;
            $ticket->status = "new";
            $ticket->validity = $validity_timestamp;
            $ticket->created_at = $current_timestamp;
            $ticket->updated_at = $current_timestamp;

            return $ticket;
        }

        return null;
    }

    /**
     * Generate QR code as image
     * 
     * Upload QR-Code image and return the link to the uploaded image - using handleImageUpload()
     */
    public function generateQrCode(Ticket $ticket) 
    {
        $centerImagePath = base_path('/storage/app/public/images/CamWiGo_logo.png');

        $agencyLogo = Setting::where('label', 'logo')->value('value');
        $centerImagePath = base_path('/storage/app/public'.$agencyLogo);

        $encodedTicketData = base64_encode($ticket);

        $qrCode = QrCode::encoding('UTF-8')
            ->margin(1)
            ->style('round', 0.99)
            ->format('png')
            ->size(400)
            ->merge($centerImagePath, .4, true)
            ->generate($encodedTicketData);
        
        $imageName = 'ticket-qr-codes' . '/' . time() . '_' . uniqid() . $ticket->id . '_' . $ticket->created_at . '-' . $ticket->validity . $ticket->reservation_id . '_qr_code.png';
        $filePath = 'public/images/' . $imageName;

        Storage::put($filePath, $qrCode);

        $imageLink = '/images/' . $imageName;

        return $imageLink;
    }
}
