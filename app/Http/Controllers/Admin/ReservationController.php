<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\VehicleRouteDestination;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Requests\UpdateReservationRequest;

class ReservationController extends Controller
{
    public function index(Request $request) 
    {
        $relationships = ['user', 'vehicleRouteDestination.vehicle.vehicleCategory', 'vehicleRouteDestination.routeSchedule.routeDestination.route'];
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
        $vehicleRouteDestination = VehicleRouteDestination::find($validated['vehicle_route_destination_id']);

        if($user) {
            if($vehicleRouteDestination) {
                if($vehicleRouteDestination->available_seats > 0 && $vehicleRouteDestination->reserved_seats < $vehicleRouteDestination->vehicle->vehicleCategory->size) 
                {
                    DB::beginTransaction();
                    try {
                        $reservation = new Reservation();
                        $reservation->user_id = $validated['user_id'];
                        $reservation->vehicle_route_destination_id = $validated['vehicle_route_destination_id'];
                        $reservation->position = $validated['position'];
                        $reservation->status = "pending";
                        $reservation->created_at = $current_timestamp;
                        $reservation->updated_at = $current_timestamp;
                        $reservation->save();

                        $vehicleRouteDestination->available_seats -= 1;
                        $vehicleRouteDestination->reserved_seats += 1;
                        $vehicleRouteDestination->save();
                        
                        DB::commit();

                        return response()->json(['message' => 'Reservation created successfully'], 200);
                    } 
                    catch (\Exception $e) 
                    {
                        DB::rollBack();
                        return response()->json(['message' => 'Failed to create reservation'], 500);
                    }
                }

                return response()->json(['message' => 'No available seats or all seats are reserved'], 400);
            }

            return response()->json(['message' => 'The vehicle does not exist'], 404);
        }

        return response()->json(['message' => 'The user does not exist'], 404);
    }

    public function show($id) 
    {
        $relationships = ['user', 'vehicleRouteDestination.vehicle.vehicleCategory', 'vehicleRouteDestination.routeSchedule.routeDestination.route', 'ticket'];
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
