@extends('admin.layouts.app')

@section('subtitle', 'Welcome')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h1 class="m-0">
                @yield('content_header_title', 'Journey Route')
                <small class="text-muted ml-2">
                    <i class="fas fa-xs fa-angle-right text-muted mx-1"></i>
                    @yield('content_header_subtitle', 'From ' . $journeyRoute->origin)
                </small>
            </h1>
        </div>
        <div>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDestinationModal">
                <i class="fas fa-plus"></i> Add New Route Destination
            </button>
        </div>
    </div>
@stop

@section('content_body')
<div class="container">

    <!-- Add Destination Modal -->
    <div class="modal fade" id="addDestinationModal" tabindex="-1" role="dialog" aria-labelledby="addDestinationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDestinationModalLabel">Add New Route Destination</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('route-destinations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="route_id" value="{{ $journeyRoute->id }}">
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <select class="form-control" name="destination" required>
                                @foreach($towns as $town)
                                    <option value="{{ $town }}">{{ $town }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
    @foreach($journeyRoute->routeDestinations as $destination)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="d-flex justify-content-between">
                <span>Destination: <b>{{ $destination->destination }}</b></span>
                <div>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDestinationModal{{ $destination->id }}">
                        <i class="fas fa-edit"></i> Edit Destination
                    </button>

                    @php
                        $canDelete = true;
                        foreach($destination->routeSchedules as $schedule) {
                            if ($schedule->vehicleRouteDestinations->isNotEmpty()) {
                                $canDelete = false;
                                break;
                            }
                        }
                    @endphp

                    @if($canDelete)
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteDestinationModal{{ $destination->id }}">
                        <i class="fas fa-trash"></i> Delete Destination
                    </button>
                    @endif
                </div>
            </h5>
        </div>
        <div class="card-body">
            <h5>Schedules
                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#addScheduleModal{{ $destination->id }}">
                    <i class="fas fa-plus"></i> Add Schedule
                </button>
            </h5>
            <br>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Departure Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($destination->routeSchedules as $schedule)
                    <tr>
                        <td>{{ $schedule->label }}</td>
                        <td>{{ date('H:i', strtotime($schedule->departure_time)) }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editScheduleModal{{ $schedule->id }}">
                                <i class="fas fa-edit"></i> Edit Schedule
                            </button>
                            @if ($schedule->vehicleRouteDestinations->isEmpty())
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteScheduleModal{{ $schedule->id }}">
                                <i class="fas fa-trash"></i> Delete Schedule
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Destination Modal -->
    <div class="modal fade" id="editDestinationModal{{ $destination->id }}" tabindex="-1" role="dialog" aria-labelledby="editDestinationModalLabel{{ $destination->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDestinationModalLabel{{ $destination->id }}">Edit Destination</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('route-destinations.update', $destination->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="destination">Destination</label>
                            <select class="form-control" name="destination" required>
                                @foreach($towns as $town)
                                    <option value="{{ $town }}" {{ $town == $destination->destination ? 'selected' : '' }}>{{ $town }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $destination->price }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Schedule Modal -->
    <div class="modal fade" id="addScheduleModal{{ $destination->id }}" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel{{ $destination->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel{{ $destination->id }}">Add New Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('route-schedules.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="route_destination_id" value="{{ $destination->id }}">
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control" name="label" required>
                        </div>
                        <div class="form-group">
                            <label for="departure_time">Departure Time</label>
                            <input type="time" class="form-control" name="departure_time" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Schedule Modal -->
    @foreach($destination->routeSchedules as $schedule)
    <div class="modal fade" id="editScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editScheduleModalLabel{{ $schedule->id }}">Edit Schedule: For {{ $journeyRoute->origin }} -- {{ $destination->destination }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('route-schedules.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control" name="label" value="{{ old('label', $schedule->label) }}">
                        </div>
                        <div class="form-group">
                            <label for="departure_time">Departure Time</label>
                            <input type="time" class="form-control" name="departure_time" value="{{ old('departure_time', $schedule->departure_time) }}">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Delete Destination Confirmation Modal -->
    <div class="modal fade" id="deleteDestinationModal{{ $destination->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteDestinationModalLabel{{ $destination->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDestinationModalLabel{{ $destination->id }}">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this destination?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('route-destinations.destroy', $destination->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Schedule Confirmation Modal -->
    @foreach($destination->routeSchedules as $schedule)
    <div class="modal fade" id="deleteScheduleModal{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleModalLabel{{ $schedule->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteScheduleModalLabel{{ $schedule->id }}">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this schedule?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('route-schedules.destroy', $schedule->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @endforeach
    <br>
</div>
@stop

@push('css')
    <link rel="stylesheet" href="/css/app.css">
@endpush

@push('js')
@endpush
