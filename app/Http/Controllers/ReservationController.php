<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request) 
    {
        $relationships = ['user', 'vehicle.vehicleCategory'];
        $allReservations = Reservation::all()->with($relationships);

        if(!$allReservations->isEmpty()) {
            return ReservationResource::collection($allReservations);
        }

        return response()->json(['message' => 'There are no available reservations'], 404);
    }

    public function store(ReservationRequest $request) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();

        $user = User::find($validated['user_id']);
        $vehicle = Vehicle::find($validated['vehicle_id']);

        if($user) {
            if($vehicle) {
                $reservation = new Reservation();
                $reservation->user_id = $validated['user_id'];
                $reservation->vehicle_id = $validated['vehicle_id'];
                $reservation->position = $$validated['position'];
                $reservation->status = "pending";
                $reservation->created_at = $current_timestamp;
                $reservation->updated_at = $current_timestamp;
                $reservation->save();

                // If flow-specific, send a TicketRequest from here to the handlePayment() method in PaymentController for subsequent payment handling and ticket generation

                return response()->json(['message' => 'Reservation created successfully'], 200);
            }

            return response()->json(['message' => 'The vehicle does not exist'], 404);
        }

        return response()->json(['message' => 'The user does not exist'], 404);
    }

    public function show($id) 
    {
        $relationships = ['user', 'ticket', 'vehicle.vehicleCategory', 'vehicle.route.routeSchedules', 'vehicle.route.routeDestinations'];
        $reservation = Reservation::find($id)->with($relationships);

        if(!$reservation->isEmpty()) {
            return new ReservationResource($reservation);
        }

        return response()->json(['message' => 'Vehicle not found'], 404);
    }

    public function update(UpdateReservationRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->update($validated);

            return response()->json(['message' => 'Reservation details updated successfully'], 200);
        }

        return response()->json(['message' => 'Reservation not found'], 404);
    }

    public function destroy($id) 
    {
        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->delete();

            return response()->json(['message' => 'Reservation deleted successfully'], 200);
        }
        
        return response()->json(['message' => 'Reservation not found'], 404);
    }
}
