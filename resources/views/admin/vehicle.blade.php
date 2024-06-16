@extends('admin.layouts.app')

@section('subtitle', 'Vehicle')
@section('content_header_title', 'Vehicle')
@section('content_header_subtitle', 'All')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h1 class="m-0">
                @yield('content_header_title', 'Vehicle')
                <small class="text-muted ml-2">
                    <i class="fas fa-xs fa-angle-right text-muted mx-1"></i>
                    @yield('content_header_subtitle', 'All')
                </small>
            </h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vehicleModal">
                <i class="fas fa-plus"></i> Add New Vehicle
            </button>
        </div>
    </div>
@stop

@section('content_body')
    @section('plugins.Datatables', true)
    @php
        $data = [];
        foreach ($allVehicles as $vehicle) {
            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#editVehicleModal' . $vehicle->id . '">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
            $btnDelete = '<form action="' . route('vehicles.destroy', $vehicle->id) . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this vehicle?\')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                          </form>';
            $btnDetails = '<a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" href="' . route('vehicles.show', $vehicle->id) . '">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </a>';

            // Initialize an array to hold origins and their corresponding destinations
            $routes = [];

            // Iterate through each route destination of the vehicle
            foreach ($vehicle->vehicleRouteDestinations as $routeDestination) {
                $origin = $routeDestination->routeSchedule->routeDestination->route->origin;
                $destination = $routeDestination->routeSchedule->routeDestination->destination;

                // Add the destination to the corresponding origin in the array
                if (!isset($routes[$origin])) {
                    $routes[$origin] = [];
                }
                $routes[$origin][] = $destination;
            }

            // Build the origins and destinations display string
            $originDestinations = '';
            foreach ($routes as $origin => $destinations) {
                $uniqueDestinations = array_unique($destinations);
                $destinationsString = implode(' ', array_map(function($destination) {
                    return '<span class="badge badge-destination">' . $destination . '</span>';
                }, $uniqueDestinations));

                $originDestinations .= '<div class="mb-2">';
                $originDestinations .= '<span class="badge badge-origin">' . $origin . '</span>';
                $originDestinations .= ' <b style="font-size: 25px">:</b> ';
                $originDestinations .= $destinationsString ?: '<span class="badge badge-none">None</span>';
                $originDestinations .= '</div>';
            }

            $data[] = [
                $vehicle->id,
                $vehicle->name,
                $vehicle->vehicleCategory->name,
                $originDestinations ?: '<span class="badge badge-none">None</span>',
                '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>'
            ];
        }

        $heads = [
            'ID',
            'Name',
            'Category',
            'Routes (Origin : Destination(s))',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => $data,
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <hr>
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config"
        striped hoverable bordered compressed/>

    {{-- Add New Vehicle Category Modal --}}
    <div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vehicleModalLabel">Add New Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehicleForm" action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Example with empty option (for Select2) --}}
                        <label for="size">Select Fleet Category</label>
                        <x-adminlte-select2 name="vehicle_category_id" igroup-size="lg" label-class="text-lightblue" data-placeholder="Select an option...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-gradient-info">
                                    <i class="fas fa-car-side"></i>
                                </div>
                            </x-slot>
                            @foreach($allVehicleCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-adminlte-select2>

                        <div class="form-group">
                            <label for="name">Vehicle Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Vehicle Category Modals --}}
    @foreach($allVehicles as $vehicle)
    <div class="modal fade" id="editVehicleModal{{ $vehicle->id }}" tabindex="-1" role="dialog" aria-labelledby="editVehicleModalLabel{{ $vehicle->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editVehicleModalLabel{{ $vehicle->id }}">Edit Vehicle</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editvehicleForm{{ $vehicle->id }}" action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-id-{{ $vehicle->id }}" name="id" value="{{ $vehicle->id }}">

                        <div class="form-group">
                            <label for="name-{{ $vehicle->id }}">Vehicle Name</label>
                            <input type="text" class="form-control" id="name-{{ $vehicle->id }}" name="name" value="{{ $vehicle->name }}" required>
                        </div>

                        <button type="submit" class="btn btn-success" id="edit-submitBtn-{{ $vehicle->id }}">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@stop

@push('css')

@endpush

@push('js')

@endpush
