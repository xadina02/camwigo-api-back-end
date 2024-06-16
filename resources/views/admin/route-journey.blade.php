@extends('admin.layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Journey Routes')
@section('content_header_subtitle', 'All')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h1 class="m-0">
                @yield('content_header_title', 'Journey Routes')
                <small class="text-muted ml-2">
                    <i class="fas fa-xs fa-angle-right text-muted mx-1"></i>
                    @yield('content_header_subtitle', 'All')
                </small>
            </h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#routeModal">
                <i class="fas fa-plus"></i> Add New Journey Route
            </button>
        </div>
    </div>
@stop

{{-- Content body: main page content --}}

@section('content_body')
    @section('plugins.Datatables', true)
    @php
        $data = [];
        foreach ($allRoutes as $route) {
            $btnDelete = '<form action="' . route('journey-routes.destroy', $route->id) . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this journey route?\')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                          </form>';
            $btnDetails = '<a class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details" href="' . route('journey-routes.show', $route->id) . '">
                            <i class="fa fa-lg fa-fw fa-eye"></i>
                        </a>';
            
            $destinations = [];
            $origin = '<span class="badge badge-origin">None</span>';
            
            $origin = '<span class="badge badge-origin">' . $route->origin . '</span>';
            foreach($route->routeDestinations as $routeDest) {
                $destinations[] = '<span class="badge badge-destination">' . $routeDest->destination . '</span>';
            }

            $destinationsString = implode(' ', $destinations);

            $data[] = [
                $route->id,
                $origin,
                $destinationsString ?: '<span class="badge badge-destination">None</span>',
                '<nobr>' . $btnDelete . $btnDetails . '</nobr>'
            ];
        }

        $heads = [
            'ID',
            'Origin',
            'Destinations',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => $data,
            'columns' => [null, null, null, ['orderable' => false]],
        ];
    @endphp
    <hr>
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config"
        striped hoverable bordered compressed/>

    {{-- Add New route Category Modal --}}
    <div class="modal fade" id="routeModal" tabindex="-1" role="dialog" aria-labelledby="routeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="routeModalLabel">Add New Route</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="routeForm" action="{{ route('journey-routes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="selBsCategory">Origin</label>
                            <select id="selBsCategory" class="form-control select2" name="origin">
                                @foreach($towns as $town)
                                <option value="{{ $town }}">{{ $town }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="selBsCategory">Destination</label>
                            <select id="selBsCategory" class="form-control select2" name="destination">
                                @foreach($towns as $town)
                                <option value="{{ $town }}">{{ $town }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="size">Journey Price</label>
                            <input type="number" class="form-control" id="size" name="price" placeholder="Enter number" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@endpush