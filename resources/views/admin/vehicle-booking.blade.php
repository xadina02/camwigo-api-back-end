@extends('admin.layouts.app')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Vehicle')
@section('content_header_subtitle', $vehicle->name)

@section('content_body')

    <!-- Display success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display error messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <h3 style="margin-bottom: -10px;">Details</h3>
        <!-- Button to open the modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#attributeRouteModal">
            Add New Journey Route
        </button>
    </div>

    <div class="vehicle-info mt-4">
        <div class="d-flex align-items-center">
            <img src="{{ config('app.url') . '/storage' . $vehicle->vehicleCategory->icon_link }}" alt="Category Icon" class="category-icon mr-3">
            <div>
                <h3 class="mb-2">{{ $vehicle->name }}</h3>
                <p class="mb-1"><strong>Category:</strong> <b class="badge-destination">{{ $vehicle->vehicleCategory->name }}</b></p>
                <p class="mb-0"><strong>Max Seats:</strong> <b class="badge-origin">{{ $vehicle->vehicleCategory->size }}</b></p>
            </div>
        </div>
    </div>

    @php
        // Group by unique origin-destination pairs
        $uniqueRouteDestinations = $vehicle->vehicleRouteDestinations->groupBy(function($destination) {
            return $destination->routeSchedule->routeDestination->route->origin . '-' . $destination->routeSchedule->routeDestination->destination;
        });
    @endphp

    @foreach($uniqueRouteDestinations as $key => $groupedDestinations)
        @php
            // Sort destinations by journey_date within this group
            $sortedDestinations = $groupedDestinations->sortBy('journey_date');
            $destination = $sortedDestinations->first();

            $data = [];
            foreach ($sortedDestinations as $vRouteDest) {
                $btnDelete = '';
                if($vRouteDest->reservations->isEmpty()) {
                    $btnDelete = '<button type="button" class="btn btn-danger delete-button" data-id="' . $vRouteDest->id . '" data-url="' . route('vehicles-route-destinations.destroy', $vRouteDest->id) . '">Delete</button>';
                }
                
                $data[] = [
                    $vRouteDest->routeSchedule->label,
                    Carbon\Carbon::parse($vRouteDest->journey_date)->format('d M Y'),
                    Carbon\Carbon::parse($vRouteDest->routeSchedule->departure_time)->format('h:i A'),
                    $vRouteDest->available_seats,
                    $vRouteDest->reservations->count(),
                    '<nobr>' . $btnDelete . '</nobr>'
                ];
            }

            $heads = [
                'Schedule Label',
                'Journey Date',
                'Departure Time',
                'Available Seats',
                'Reserved Seats',
                ['label' => 'Actions', 'no-export' => true, 'width' => 5],
            ];

            $config = [
                'data' => $data,
                'columns' => [null, null, null, null, null, ['orderable' => false]],
            ];
        @endphp

        <div class="card2 mt-3">
            <div class="card-header2 d-flex justify-content-between align-items-center">
                <div class="route-info">
                    <h4><b>{{ $destination->routeSchedule->routeDestination->route->origin }} - {{ $destination->routeSchedule->routeDestination->destination }}</b></h4>
                    <p>Price: <b class="badge-money">{{ $destination->routeSchedule->routeDestination->price }} XAF</b></p>
                </div>
                @if($groupedDestinations->every(function($d) { return $d->reservations->isEmpty(); }))
                    <button type="button" class="btn btn-danger delete-button" data-id="{{ $destination->id }}" data-url="{{ route('vehicles-route-destinations.destroy', $destination->id) }}">Delete</button>
                @endif
            </div>

            @section('plugins.Datatables', true)
            <hr>
            <h4>Travel Journeys</h4>
            <x-adminlte-datatable id="table{{$vRouteDest->id}}" :heads="$heads" head-theme="light" :config="$config"
                striped hoverable bordered compressed/>
        </div>

    @endforeach

    <!-- Modal -->
    <div class="modal fade" id="attributeRouteModal" tabindex="-1" aria-labelledby="attributeRouteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('attributeRouteToVehicle', ['id' => $vehicle->id]) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="attributeRouteModalLabel">Add New Journey Route</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="route_destination_id">Route Destination</label>
                            <select name="route_destination_id" id="route_destination_id" class="form-control">
                                @foreach($unattributedRouteDestinations as $routeDestination)
                                    <option value="{{ $routeDestination->id }}">{{ $routeDestination->route->origin }} - {{ $routeDestination->destination }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="travel_dates">Travel Dates</label>
                            <input type="text" name="dates[]" id="travel_dates" class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label for="travel_dates">Travel Dates</label>
                            <input type="text" id="travel_dates" class="form-control" required>
                        </div>
                        <div id="date-inputs-container"></div>
                        {{-- <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}"> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#travel_dates').datepicker({
                format: 'yyyy-mm-dd',
                multidate: true,
                multidateSeparator: ',',
                startDate: 'today',
                todayHighlight: true
            }).on('changeDate', function(e) {
                var datesString = $('#travel_dates').val();
                var datesArray = datesString.split(',').map(function(date) {
                    return date.trim();
                });

                $('#date-inputs-container').empty();
                datesArray.forEach(function(date) {
                    $('#date-inputs-container').append('<input type="hidden" name="dates[]" value="' + date + '">');
                });
            });

            $('#routeForm').submit(function(e) {
                e.preventDefault();
                this.submit();
            });

            // Pagination logic for tables
            $('table[data-pagination]').each(function() {
                var $table = $(this);
                var $rows = $table.find('tbody tr');
                var rowsPerPage = 10; // Number of rows per page
                var totalPages = Math.ceil($rows.length / rowsPerPage);

                if (totalPages <= 1) return; // No need for pagination if only one page

                var currentPage = 1;
                $rows.hide(); // Hide all rows initially
                $rows.slice(0, rowsPerPage).show(); // Show the first set of rows

                // Create pagination controls
                var $paginationControls = $('<div class="pagination-controls"></div>');
                for (var i = 1; i <= totalPages; i++) {
                    var $pageLink = $('<a href="#" class="page-link">' + i + '</a>');
                    $pageLink.data('page', i);
                    $paginationControls.append($pageLink);
                }

                // Add controls to the table container
                $table.after($paginationControls);

                // Set the first page as active initially
                $paginationControls.find('.page-link').first().addClass('active');

                // Handle page click
                $paginationControls.on('click', '.page-link', function(e) {
                    e.preventDefault();
                    var $link = $(this);
                    currentPage = $link.data('page');
                    var start = (currentPage - 1) * rowsPerPage;
                    var end = start + rowsPerPage;

                    // Hide all rows and show only the rows for the current page
                    $rows.hide().slice(start, end).show();
                    $paginationControls.find('.page-link').removeClass('active');
                    $link.addClass('active');
                });
            });

            // Confirmation Modal
            $(document).on('click', '.delete-button', function() {
                var url = $(this).data('url');
                var modal = $('#deleteConfirmationModal');
                modal.find('#confirmDelete').data('url', url);
                modal.modal('show');
            });

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