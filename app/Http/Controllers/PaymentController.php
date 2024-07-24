<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\User;
use Stripe\Customer;
use App\Models\Ticket;
use App\Models\Setting;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{
    /**
     * Handle Payment
     */
    public function handlePayment(TicketRequest $request, $reservation_id)
    {
        $validated = $request->validated();

        $userId = auth('sanctum')->user()->id;
        $user = User::find($userId);

        $reservation = Reservation::find($reservation_id);

        if ($reservation) {
            $amount = $validated['amount'];
            // $amount = $reservation->vehicleRouteDestination->price;

            Stripe::setApiKey(config('services.stripe.secret'));

            try {
                // Create a Charge
                $charge = Charge::create([
                    'amount' => $validated['amount'], // Amount in cents
                    'currency' => 'xaf',
                    'source' => 'tok_visa',
                    'description' => 'Payment from Laravel app for account number ' . $validated['account_number'],
                ]);

                $reservation->amount_paid += $amount;
                $reservation->save();

                if ($reservation->amount_paid < ($reservation->vehicleRouteDestination->routeSchedule->routeDestination->price * $reservation->reservationPositions->count())) {
                    $reservation->status = "partial";
                    $reservation->save();

                    return response()->json(['message' => 'Payment received. Complete your payment to get boarding pass!'], 200);
                }

                if ($reservation->amount_paid >= ($reservation->vehicleRouteDestination->routeSchedule->routeDestination->price * $reservation->reservationPositions->count())) {
                    $reservation->status = "paid";
                    $reservation->save();

                    $ticket = $this->generateTicket($reservation_id);

                    if ($ticket != null) {
                        $qr_code_link = $this->generateQrCode($ticket);

                        $ticket->QR_code_image_link = $qr_code_link;
                        $ticket->save();

                        $reservation->status = "completed";
                        $reservation->save();

                        return response()->json(['message' => 'Payment successful! Reservation created!'], 200);
                    }

                    return response()->json(['message' => 'Oops!! Something occurred and we couldn\'t process your ticket.'], 500);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'The reservation to pay for could not be found.'], 404);
    }

    public function generateTicket($id): Ticket
    {
        $reservation = Reservation::find($id);

        $current_timestamp = Carbon::now();
        $validity_timestamp = Carbon::now()->format('Y-m-d') . ' ' . Carbon::parse($reservation->vehicleRouteDestination->routeSchedule->departure_time)->addMinutes(30)->format('H:i:s');

        if ($reservation) {
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
        $user = auth()->user();

        $centerImagePath = base_path('/storage/app/public/images/CamWiGo_logo.png');

        $agencyLogo = Setting::where('label', 'logo')->value('value');
        $centerImagePath = base_path('/storage/app/public' . $agencyLogo);

        $ticketData = [
            'ticket_id' => $ticket->id,
            'reservation_id' => $ticket->reservation_id,
            'validity' => $ticket->validity,
            'status' => $ticket->status,
            'user_id' => $user->id,
        ];

        // $encodedTicketData = base64_encode(serialize($ticketData));
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
