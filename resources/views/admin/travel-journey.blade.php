@extends('admin.layouts.app')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Travel Journeys')
@section('content_header_subtitle', 'All')

@section('content_body')
    <!-- Filter Form -->
    <form id="filterForm">
        <div class="row">
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
                <label for="route_schedule_label">Route Schedule Label</label>
                <input type="text" class="form-control" id="route_schedule_label" name="route_schedule_label" placeholder="Route Schedule Label">
            </div>
            <div class="col-sm-2 mb-2">
                <label for="route_schedule_time">Route Schedule Time</label>
                <input type="time" class="form-control" id="route_schedule_time" name="route_schedule_time">
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

    <div class="table-responsive">
        @php
            $heads = [
                'Vehicle Name',
                'Vehicle Category',
                'Route Origin',
                'Route Destination',
                'Route Schedule Label',
                'Route Schedule Time',
                'Available Seats',
                'Reserved Seats',
                'Journey Date',
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];

            $data = [];
            $travelJourneys = $travelJourneys->sortBy('journey_date');
            foreach($travelJourneys as $journey) {
                $data[] = [
                    $journey->vehicle->name,
                    $journey->vehicle->vehicleCategory->name,
                    $journey->routeSchedule->routeDestination->route->origin,
                    $journey->routeSchedule->routeDestination->destination,
                    $journey->routeSchedule->label,
                    \Carbon\Carbon::parse($journey->routeSchedule->departure_time)->format('h:i A'),
                    $journey->available_seats,
                    $journey->reservations->count(),
                    \Carbon\Carbon::parse($journey->journey_date)->format('d M Y'),
                    '<button type="button" class="btn btn-danger delete-button" data-id="' . $journey->id . '" data-url="' . route('vehicles-route-destinations.destroy', $journey->id) . '">Delete</button>'
                ];
            }

            $config = [
                'data' => $data,
                'columns' => [null, null, null, null, null, null, null, null, null, ['orderable' => false]],
            ];
        @endphp

        @section('plugins.Datatables', true)
        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" striped hoverable bordered compressed/>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this journey?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')
    <!-- Additional CSS if needed -->
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Apply Filters Button Click Event
            $('#applyFilters').click(function() {
                applyFilters();
            });

            // Reset Filters Button Click Event
            $('#resetFilters').click(function() {
                $('#filterForm')[0].reset();
                applyFilters();
            });

            function applyFilters() {
                createAndShowLoader(); // Show loader while fetching data

                var formData = $('#filterForm').serialize();
                $.ajax({
                    url: '{{ route("travelJourneys") }}',
                    method: 'GET',
                    data: formData,
                    success: function(response) {
                        updateTable(response.data);
                        removeLoader(); // Hide loader on successful data load
                    },
                    error: function() {
                        removeLoader(); // Hide loader on error
                        alert('An error occurred while applying filters.');
                    }
                });
            }

            function updateTable(data) {
                var table = $('#table1').DataTable();
                table.clear();
                table.rows.add(data);
                table.draw();
            }

            function createAndShowLoader() {
                // Create loader dynamically
                var loader = $('<div>', {
                    id: 'dynamic-loader',
                    class: 'overlay d-flex justify-content-center align-items-center',
                    html: '<i class="fas fa-2x fa-sync fa-spin" style="color: #ffffff;"></i>',
                    css: {
                        position: 'fixed',
                        width: '100%',
                        height: '100%',
                        top: '0',
                        left: '0',
                        backgroundColor: 'rgba(0, 0, 0, 0.5)',
                        zIndex: '1000'
                    }
                });
                $('body').append(loader); // Append loader to the body
            }

            function removeLoader() {
                $('#dynamic-loader').remove(); // Remove loader from the DOM
            }

            // Delete confirmation modal
            $(document).on('click', '.delete-button', function() {
                var url = $(this).data('url');
                var modal = $('#deleteConfirmationModal');
                modal.find('#confirmDelete').data('url', url);
                modal.modal('show');
            });

            // Confirm Delete Button Click Event
            $('#confirmDelete').click(function() {
                var url = $(this).data('url');
                var form = $('<form action="' + url + '" method="POST" style="display:none;"></form>');
                form.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                form.append('<input type="hidden" name="_method" value="DELETE">');
                $('body').append(form);
                form.submit();
            });
        });
    </script>
@endpush
