@extends('admin.layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Dashboard')
@section('content_header_subtitle', 'Get Started')

{{-- Content body: main page content --}}

@section('content_body')
    <div class="widget-container">
        <x-adminlte-small-box title="{{ $numVehicles }}" text="Vehicles" icon="fas fa-bus"
        theme="yellow" url="vehicles" url-text="Manage Vehicles"/>

        <x-adminlte-small-box title="{{ $numRoutes }}" text="Routes" icon="fas fa-road"
        theme="danger" url="journey-routes" url-text="Manage Routes"/>

        <x-adminlte-small-box title="{{ $numReservations }}" text="Reservations" icon="fas fa-clipboard-check"
        theme="green" url="reservations" url-text="Manage Reservations"/>

        <x-adminlte-small-box title="{{ $numUsers }}" text="Users" icon="fas fa-users"
        theme="blue" url="manage-users/all" url-text="Manage Users"/>
    </div>

    @section('plugins.Datatables', true)
    {{-- Setup data for datatables --}}
    @php
    
    // $config2 = [
    //     'data' => [
    //         [22, 'John Bender', '+02 (123) 123456789', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    //         [19, 'Sophia Clemens', '+99 (987) 987654321', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    //         [3, 'Peter Sousa', '+69 (555) 12367345243', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
    //     ],
    //     'order' => [[1, 'asc']],
    //     'columns' => [null, null, null, ['orderable' => false]],
    // ];

    $data = [];
    foreach ($latestReservations as $reservation) {
        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </button>';
        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>';
        $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </button>';
        
        $data[] = [
            $reservation->user->first_name . ' ' . $reservation->user->last_name,
            $reservation->vehicleRouteDestination->routeSchedule->routeDestination->route->origin . '-' . $reservation->vehicleRouteDestination->routeSchedule->routeDestination->destination,
            $reservation->vehicleRouteDestination->journey_date,
            $reservation->position,
            $reservation->status,
            $reservation->amount_paid,
            $reservation->vehicleRouteDestination->routeSchedule->routeDestination->price,
            '<nobr>' . $btnEdit . $btnDelete . $btnDetails . '</nobr>'
        ];
    }

    $heads = [
        'User',
        'Journey',
        'Travel Date',
        'Position',
        'Status',
        'Amount Paid',
        'Total Fair',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    $config = [
        'data' => $data,
        'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
    ];
    
    
    $data2 = [];
    foreach ($latestUsers as $user) {
        $btnEdit2 = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </button>';
        $btnDelete2 = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                    </button>';
        $btnDetails2 = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                        <i class="fa fa-lg fa-fw fa-eye"></i>
                    </button>';
        
        $data2[] = [
            $user->id,
            $user->first_name . ' ' . $user->last_name,
            $user->email ?: 'Not Found',
            $user->phone ?: 'Not Found',
            '<nobr>' . $btnEdit2 . $btnDelete2 . $btnDetails2 . '</nobr>'
        ];
    }

    $heads2 = [
        'ID',
        'Name',
        'Email',
        'Phone',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    $config2 = [
        'data' => $data2,
        'columns' => [null, null, null, null, ['orderable' => false]],
    ];

    @endphp
    <hr>
    <h3 class="datatable-title">Latest Reservations</h3>
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config"
    striped hoverable bordered compressed/>
    <br>
    <hr>
    <br>
    <h3 class="datatable-title">Users</h3>
    <x-adminlte-datatable id="table2" :heads="$heads2" head-theme="light" :config="$config2"
    striped hoverable bordered compressed/>

@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/app.css">
    
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    
@endpush