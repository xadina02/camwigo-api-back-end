@extends('admin.layouts.app')

@section('subtitle', 'Reservation Detail')
@section('content_header_title', 'Reservation Detail')
@section('content_header_subtitle', 'Details')

@section('content_body')
    <div class="container">
        <!-- Top Section -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between">
                <h3 class="header-title">Reservation Details</h3>
                @if($reservation->status !== 'blocked')
                    <button class="btn btn-danger" id="blockReservationButton">Block Reservation</button>
                @endif
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-user"></i> User</h5>
                        <p class="info-value">{{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-car"></i> Vehicle</h5>
                        <p class="info-value">{{ $reservation->vehicleRouteDestination->vehicle->name }}
                            ({{ $reservation->vehicleRouteDestination->vehicle->vehicleCategory->name }})
                            <img src="{{ config('app.url') . '/storage' . $reservation->vehicleRouteDestination->vehicle->vehicleCategory->icon_link }}" alt="Category Icon" style="width: 20px; height: 20px;">
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-map-marker-alt"></i> Route Origin</h5>
                        <p class="info-value">{{ $reservation->vehicleRouteDestination->routeSchedule->routeDestination->route->origin }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-map-signs"></i> Route Destination</h5>
                        <p class="info-value">{{ $reservation->vehicleRouteDestination->routeSchedule->routeDestination->destination }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-clock"></i> Route Schedule</h5>
                        <p class="info-value">{{ $reservation->vehicleRouteDestination->routeSchedule->label }}</p>
                        <p class="info-value">{{ \Carbon\Carbon::parse($reservation->vehicleRouteDestination->routeSchedule->departure_time)->format('h:i A') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-dollar-sign"></i> Journey Fare</h5>
                        <p class="info-value">{{ $reservation->vehicleRouteDestination->routeSchedule->routeDestination->price }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-coins"></i> Amount Paid</h5>
                        <p class="info-value">{{ $reservation->amount_paid }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-info-circle"></i> Status</h5>
                        <p class="info-value {{ 'status-' . $reservation->status }}" style="width: 50%">{{ ucfirst($reservation->status) }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-list-ol"></i> Position</h5>
                        <p class="info-value">{{ $reservation->position }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5 class="info-title"><i class="fas fa-calendar-alt"></i> Journey Date</h5>
                        <p class="info-value">{{ \Carbon\Carbon::parse($reservation->vehicleRouteDestination->journey_date)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section for Ticket -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="header-title">Ticket Details</h3>
            </div>
            <div class="card-body">
                @if($reservation->ticket)
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="info-title"><i class="fas fa-qrcode"></i> QR Code</h5>
                            <img src="{{ config('app.url') . '/storage' . $reservation->ticket->QR_code_image_link }}" alt="QR Code" style="width: 250px; height: 250px;">
                        </div>
                        <div class="col-md-6">
                            <h5 class="info-title"><i class="fas fa-ticket-alt"></i> Ticket Status</h5>
                            <p class="info-value">{{ ucfirst($reservation->ticket->status) }}</p>
                            <h5 class="info-title"><i class="fas fa-calendar-check"></i> Validity Date</h5>
                            <p class="info-value">{{ \Carbon\Carbon::parse($reservation->ticket->validity_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                @else
                    <p class="info-value">No ticket details available for this reservation.</p>
                @endif
            </div>
        </div>
        <br>
    </div>

    <!-- Block Confirmation Modal -->
    <div class="modal fade" id="confirmBlockModal" tabindex="-1" role="dialog" aria-labelledby="confirmBlockModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmBlockModalLabel">Confirm Block</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to block this reservation?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmBlockButton" class="btn btn-danger">Block</button>
                </div>
            </div>
        </div>
    </div>

@stop

@push('css')

@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Show block confirmation modal
            $('#blockReservationButton').click(function() {
                $('#confirmBlockModal').modal('show');
            });

            // Handle block confirmation
            $('#confirmBlockButton').click(function() {
                var url = '{{ route("blockReservation", $reservation->id) }}';
                var form = $('<form action="' + url + '" method="POST" style="display:none;"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="_method" value="POST">');
                $('body').append(form);
                form.submit();
            });
        });
    </script>
@endpush
