<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Reservation;
use App\Models\RouteSchedule;
use App\Models\RouteDestination;
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
    public function handlePayment(TicketRequest $request, $id)
    {
        $validated = $request->validated();

        /*
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => 1000, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Test payment from Laravel app',
        ]);
        */

        // Generate and return ticket details
        $ticket = $this->generateTicket($validated, $id);
        
        // Generate, save and return the link to the QR-Code using the ticket details gotten above
        if($ticket != null) {
            $qr_code_link = $this->generateQrCode($ticket);
        }

        // Update the ticket with the QR-Code and save
        $ticket->QR_code_image_link = $qr_code_link;
        $ticket->save();

        return response()->json(['message' => 'Payment successful! Reservation created!'], 200);
    }

    public function generateTicket($data, $id): Ticket
    {
        $reservation = Reservation::find($id);
        $routeSchedule = RouteSchedule::find($data['route_schedule_id']);
        $routeDestination = RouteDestination::find($data['route_destination_id']);

        $current_timestamp = Carbon::now();
        $validity_timestamp = Carbon::now()->format('Y-m-d') . ' ' . Carbon::parse($routeSchedule->departure_time)->addMinutes(15)->format('H:i:s');

        if($routeDestination) {
            if($routeSchedule) {
                if($reservation) {
                    $ticket = new Ticket();
                    $ticket->reservation_id = $id;
                    $ticket->route_schedule_id = $data['route_schedule_id'];
                    $ticket->route_destination_id = $data['route_destination_id'];
                    $ticket->status = "new";
                    $ticket->validity = $validity_timestamp;
                    $ticket->created_at = $current_timestamp;
                    $ticket->updated_at = $current_timestamp;

                    return $ticket;
                }

                return null;
            }

            return null;
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

        // Get agencyLogo to embed
        $agencyLogo = Setting::where('label', 'logo')->value('value');
        $centerImagePath = base_path('/storage/app/public'.$agencyLogo);

        // Generate the QR code
        $qrCode = QrCode::encoding('UTF-8')->margin(1)->style('round', 0.99)->format('png')->size(400)->merge($centerImagePath, .4, true)->generate($ticket);
        
        // Define the data and file path
        $imageName = 'ticket-qr-codes' . '/' . time() . '_' . uniqid() . $ticket->id . $ticket->reservation_id . $ticket->route_schedule_id . $ticket->route_destination . '_qr_code.png';
        $filePath = 'public/images/' . $imageName;

        // Use Storage facade to save the QR code
        // Storage::put($filePath, (string) $qrCodeImage->encode('png'));
        Storage::put($filePath, $qrCode);

        $imageLink = '/images/' . $imageName;
        return $imageLink;
    }
}
