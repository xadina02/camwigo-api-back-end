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
        // Start with base query
        $query = Reservation::with([
            'user', 
            'vehicleRouteDestination.vehicle', 
            'vehicleRouteDestination.routeSchedule.routeDestination.route'
        ])->with('vehicleRouteDestination.routeSchedule.routeDestination');

        // Apply filters based on request parameters
        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->whereRaw('LOWER(CONCAT(first_name, " ", last_name)) LIKE ?', ['%' . strtolower($request->user_name) . '%']);
            });
        }

        if ($request->filled('vehicle_name')) {
            $query->whereHas('vehicleRouteDestination.vehicle', function($q) use ($request) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->vehicle_name) . '%']);
            });
        }

        if ($request->filled('route_origin')) {
            $query->whereHas('vehicleRouteDestination.routeSchedule.routeDestination.route', function($q) use ($request) {
                $q->whereRaw('LOWER(origin) LIKE ?', ['%' . strtolower($request->route_origin) . '%']);
            });
        }

        if ($request->filled('route_destination')) {
            $query->whereHas('vehicleRouteDestination.routeSchedule.routeDestination', function($q) use ($request) {
                $q->whereRaw('LOWER(destination) LIKE ?', ['%' . strtolower($request->route_destination) . '%']);
            });
        }

        if ($request->filled('schedule_time')) {
            $query->whereHas('vehicleRouteDestination.routeSchedule', function($q) use ($request) {
                $q->whereTime('departure_time', $request->schedule_time);
            });
        }

        if ($request->filled('reservation_status')) {
            $query->where('status', $request->reservation_status);
        }

        if ($request->filled('journey_date')) {
            $query->whereHas('vehicleRouteDestination', function($q) use ($request) {
                $q->whereDate('journey_date', $request->journey_date);
            });
        }

        // Retrieve filtered reservations
        $allReservations = $query->get();

        // Prepare data for DataTable
        $data = $allReservations->map(function($reservation) {
            return [
                $reservation->user->first_name . ' ' . $reservation->user->last_name,
                $reservation->vehicleRouteDestination->vehicle->name,
                $reservation->vehicleRouteDestination->routeSchedule->routeDestination->route->origin,
                $reservation->vehicleRouteDestination->routeSchedule->routeDestination->destination,
                \Carbon\Carbon::parse($reservation->vehicleRouteDestination->routeSchedule->departure_time)->format('h:i A'),
                $reservation->vehicleRouteDestination->routeSchedule->routeDestination->price, // Assuming a price attribute
                $reservation->amount_paid,
                $reservation->position,
                \Carbon\Carbon::parse($reservation->vehicleRouteDestination->journey_date)->format('d M Y'),
                $reservation->status,
                '<nobr>' . '<button type="button" class="btn btn-danger delete-button" data-id="' . $reservation->id . '" data-url="' . route('reservations.destroy', $reservation->id) . '">Delete</button>' . '</nobr>',
            ];
        });

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            return response()->json(['data' => $data]);
        }

        // Handle non-AJAX request by returning view with all reservations
        return view('admin.reservation', compact('allReservations'));
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

                        return redirect()->back()->with('success', 'Reservation created successfully');
                    } 
                    catch (\Exception $e) 
                    {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Failed to create reservation');
                    }
                }

                return redirect()->back()->with('error', 'No available seats');
            }

            return redirect()->back()->with('error', 'The vehicle journey not exist');
        }

        return redirect()->back()->with('error', 'The user does not exist');
    }

    public function show($id) 
    {
        $reservation = Reservation::find($id);

        return view('admin.reservation-detail', compact('reservation'));
    }

    public function update(UpdateReservationRequest $request, $id) 
    {
        $validated = $request->validated();

        $current_timestamp = Carbon::now();
        $validated['updated_at'] = $current_timestamp;

        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->update($validated);

            return redirect()->back()->with('success', 'Reservation details updated successfully');
        }

        return redirect()->back()->with('error', 'Reservation not found');
    }

    public function destroy($id) 
    {
        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->delete();

            return redirect()->back()->with('success', 'Reservation deleted successfully');
        }
        
        return redirect()->back()->with('error', 'Reservation not found');
    }
}
