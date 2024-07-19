<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleRouteDestination;
use App\Models\ReservationPosition;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function store(Request $request, $vehicleRouteDestinationId)
    {
        $current_timestamp = Carbon::now();

        $userId = auth('sanctum')->user()->id;
        $user = User::find($userId);

        $seats = $request->get('position');

        $vehicleRouteDestination = VehicleRouteDestination::find($vehicleRouteDestinationId);

        if ($user) {
            if ($vehicleRouteDestination) {
                if ($vehicleRouteDestination->available_seats > 0 && $vehicleRouteDestination->reserved_seats < $vehicleRouteDestination->vehicle->vehicleCategory->size) {
                    if (!empty($seats)) {
                        DB::beginTransaction();
                        try {
                            $reservation = new Reservation();
                            $reservation->user_id = $userId;
                            $reservation->vehicle_route_destination_id = $vehicleRouteDestinationId;
                            // $reservation->position = $seat;
                            $reservation->status = "pending";
                            $reservation->created_at = $current_timestamp;
                            $reservation->updated_at = $current_timestamp;
                            $reservation->save();


                            foreach ($seats as $seat) 
                            {
                                $reservationPosition = new ReservationPosition();
                                $reservationPosition->reservation_id = $reservation->id;
                                $reservationPosition->seat_number = $seat;
                                $reservationPosition->save();
                            }

                            $vehicleRouteDestination->available_seats -= sizeof($seats);
                            $vehicleRouteDestination->reserved_seats += sizeof($seats);
                            $vehicleRouteDestination->save();

                            DB::commit();

                            // return response()->json(['message' => 'Reservation created successfully', 'identifier' => $reservation->id], 200);
                            return new ReservationResource($reservation);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            return response()->json(['message' => 'Failed to create reservation'], 500);
                        }
                    }

                    return response()->json(['message' => 'No seats selected'], 400);
                }

                return response()->json(['message' => 'No available seats or all seats are reserved'], 400);
            }

            return response()->json(['message' => 'The vehicle does not exist'], 404);
        }

        return response()->json(['message' => 'The user does not exist'], 404);
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
