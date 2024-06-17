@extends('admin.layouts.app')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Reservations')
@section('content_header_subtitle', 'All')

@section('content_body')
    <!-- Filter Form -->
    <form id="filterForm">
        <div class="row">
            <div class="col-sm-2 mb-2">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" placeholder="User Name">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="vehicle_name">Vehicle Name</label>
                <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" placeholder="Vehicle Name">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="route_origin">Route Origin</label>
                <input type="text" class="form-control" id="route_origin" name="route_origin" placeholder="Route Origin">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="route_destination">Route Destination</label>
                <input type="text" class="form-control" id="route_destination" name="route_destination" placeholder="Route Destination">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="schedule_time">Schedule Time</label>
                <input type="time" class="form-control" id="schedule_time" name="schedule_time">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="reservation_status">Reservation Status</label>
                <select class="form-control" id="reservation_status" name="reservation_status">
                    <option value="">Select Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="blocked">Blocked</option>
                    <option value="partial">Partial</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="col-sm-2 mb-2">
                <label for="journey_date">Journey Date</label>
                <input type="date" class="form-control" id="journey_date" name="journey_date">
            </div>
            <div class="col-sm-2 mb-2">
                <button type="button" id="applyFilters" class="btn btn-primary mb-2">Apply Filters</button>
                <button type="button" id="resetFilters" class="btn btn-secondary mb-2">Reset Filters</button>
            </div>
        </div>
    </form>

    <!-- AdminLTE DataTable -->
    @php
        $heads = [
            'User Name',
            'Vehicle Name',
            'Route Origin',
            'Route Destination',
            'Schedule Time',
            'Journey Fare',
            'Amount Paid',
            'Position',
            'Journey Date',
            'Status',
            'Action',
        ];

        $data = [];
        foreach ($allReservations as $reservation) {
            $userName = $reservation->user->first_name . ' ' . $reservation->user->last_name;
            $vehicleName = $reservation->vehicleRouteDestination->vehicle->name;
            $routeOrigin = $reservation->vehicleRouteDestination->routeSchedule->routeDestination->route->origin;
            $routeDestination = $reservation->vehicleRouteDestination->routeSchedule->routeDestination->destination;
            $scheduleTime = \Carbon\Carbon::parse($reservation->vehicleRouteDestination->routeSchedule->departure_time)->format('h:i A');
            $journeyFare = $reservation->vehicleRouteDestination->routeSchedule->routeDestination->price;
            $amountPaid = $reservation->amount_paid;
            $position = $reservation->position;
            $journeyDate = \Carbon\Carbon::parse($reservation->vehicleRouteDestination->journey_date)->format('d M Y');
            $status = $reservation->status;
            $btnDelete = '<button type="button" class="btn btn-danger delete-button" data-id="' . $reservation->id . '" data-url="' . route('reservations.destroy', $reservation->id) . '">Delete</button>';
            $btnView = '<a href="' . route('reservations.show', $reservation->id) . '" class="btn btn-info view-button" data-id="' . $reservation->id . '">View</a>';

            // Determine status class and label
            $statusClass = '';
            switch ($status) {
                case 'completed':
                    $statusClass = 'status-completed';
                    break;
                case 'pending':
                    $statusClass = 'status-pending';
                    break;
                case 'blocked':
                    $statusClass = 'status-blocked';
                    break;
                case 'partial':
                    $statusClass = 'status-partial';
                    break;
                case 'paid':
                    $statusClass = 'status-paid';
                    break;
                default:
                    $statusClass = '';
            }

            // Format status with div for styling
            $formattedStatus = '<div class="' . $statusClass . '">' . ucfirst($status) . '</div>';

            $data[] = [
                $userName,
                $vehicleName,
                $routeOrigin,
                $routeDestination,
                $scheduleTime,
                $journeyFare . ' XAF',
                $amountPaid . ' XAF',
                $position,
                $journeyDate,
                $formattedStatus,
                '<nobr>' . $btnView . ' ' . $btnDelete . '</nobr>',
            ];
        }

        $config = [
            'data' => $data,
            'columns' => [null, null, null, null, null, null, null, null, null, ['orderable' => false], ['orderable' => true]],
        ];
    @endphp

    @section('plugins.Datatables', true)
    <x-adminlte-datatable id="reservationsTable" :heads="$heads" :config="$config" striped hoverable bordered compressed/>

    <!-- Confirm Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this reservation?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
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
            // Confirmation Modal
            $(document).on('click', '.delete-button', function() {
                var url = $(this).data('url');
                var modal = $('#confirmDeleteModal');
                modal.find('#confirmDeleteButton').data('url', url);
                modal.modal('show');
            });

            $('#confirmDeleteButton').click(function() {
                var url = $(this).data('url');
                var form = $('<form action="' + url + '" method="POST" style="display:none;"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="_method" value="DELETE">');
                $('body').append(form);
                form.submit();
            });

            $('#applyFilters').click(function() {
                applyFilters();
            });

            $('#resetFilters').click(function() {
                $('#filterForm')[0].reset();
                applyFilters();
            });

            function applyFilters() {
                showLoader(); // Show loader while fetching data

                var formData = $('#filterForm').serialize();

                $.ajax({
                    url: '{{ route("reservations.index") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        updateTable(response.data);
                        hideLoader(); // Hide loader after fetching data
                    },
                    error: function() {
                        hideLoader();
                        alert('Error fetching data');
                    }
                });
            }

            function showLoader() {
                // Create loader dynamically
                if ($('#dynamicLoader').length === 0) {
                    $('body').append('<div id="dynamicLoader" class="overlay d-flex justify-content-center align-items-center"><i class="fas fa-2x fa-sync fa-spin"></i></div>');
                }
                $('#dynamicLoader').show();
            }

            function hideLoader() {
                // Remove loader after data is fetched
                $('#dynamicLoader').remove();
            }

            function updateTable(data) {
                var table = $('#reservationsTable').DataTable();
                table.clear(); // Clear existing data from DataTable
                
                $.each(data, function(index, row) {
                    // Capitalize the status string
                    var status = row[9].charAt(0).toUpperCase() + row[9].slice(1); // Assuming row[9] is the status string
                    
                    // Determine status class based on status value
                    var statusClass = '';
                    switch (row[9]) {
                        case 'completed':
                            statusClass = 'status-completed';
                            break;
                        case 'pending':
                            statusClass = 'status-pending';
                            break;
                        case 'blocked':
                            statusClass = 'status-blocked';
                            break;
                        case 'partial':
                            statusClass = 'status-partial';
                            break;
                        case 'paid':
                            statusClass = 'status-paid';
                            break;
                        default:
                            statusClass = '';
                    }

                    // Format status with div for styling
                    var formattedStatus = '<div class="' + statusClass + '">' + status + '</div>';
                    
                    // Update the status column in the row
                    row[9] = formattedStatus;

                    // Add the modified row to DataTable
                    table.row.add(row);
                });
                
                // Redraw the DataTable with updated data
                table.draw();
            }
        });
    </script>
@endpush
