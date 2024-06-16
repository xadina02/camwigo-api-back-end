@extends('admin.layouts.app')

@section('subtitle', 'Vehicle Category')
@section('content_header_title', 'Vehicle Categories')
@section('content_header_subtitle', 'All')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h1 class="m-0">
                @yield('content_header_title', 'Vehicle Category')
                <small class="text-muted ml-2">
                    <i class="fas fa-xs fa-angle-right text-muted mx-1"></i>
                    @yield('content_header_subtitle', 'All')
                </small>
            </h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vehicleCategoryModal">
                <i class="fas fa-plus"></i> Add New Category
            </button>
        </div>
    </div>
@stop

@section('content_body')
    @section('plugins.Datatables', true)
    @php
        $data = [];
        foreach ($allVehicleCategories as $vehicleCategory) {
            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#editVehicleCategoryModal' . $vehicleCategory->id . '">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
            $btnDelete = '<form action="' . route('vehicle-categories.destroy', $vehicleCategory->id) . '" method="POST" style="display: inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow delete-btn" title="Delete" onclick="return confirm(\'Are you sure you want to delete this category?\')">
                                <i class="fa fa-lg fa-fw fa-trash"></i>
                            </button>
                          </form>';

            $data[] = [
                $vehicleCategory->id,
                '<img src="' . config('app.url') . '/storage' . $vehicleCategory->icon_link . '" alt="' . $vehicleCategory->name . ' Logo" style="height: 50px; width: auto;">',
                $vehicleCategory->name,
                $vehicleCategory->size,
                '<nobr>' . $btnEdit . $btnDelete . '</nobr>'
            ];
        }

        $heads = [
            'ID',
            'Icon',
            'Name',
            'Size',
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
    <div class="modal fade" id="vehicleCategoryModal" tabindex="-1" role="dialog" aria-labelledby="vehicleCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="vehicleCategoryModalLabel">Add New Vehicle Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehicleCategoryForm" action="{{ route('vehicle-categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Fleet Name/Type</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter label" required>
                        </div>
                        <div class="form-group">
                            <label for="size">Fleet Size</label>
                            <input type="number" class="form-control" id="size" name="size" placeholder="Enter number" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Fleet Icon</label>
                            <input type="file" class="form-control-file" id="image" name="image" required>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Vehicle Category Modals --}}
    @foreach($allVehicleCategories as $vehicleCategory)
    <div class="modal fade" id="editVehicleCategoryModal{{ $vehicleCategory->id }}" tabindex="-1" role="dialog" aria-labelledby="editVehicleCategoryModalLabel{{ $vehicleCategory->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editVehicleCategoryModalLabel{{ $vehicleCategory->id }}">Edit Vehicle Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editVehicleCategoryForm{{ $vehicleCategory->id }}" action="{{ route('vehicle-categories.update', $vehicleCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-id-{{ $vehicleCategory->id }}" name="id" value="{{ $vehicleCategory->id }}">
                        <div class="form-group">
                            <label for="edit-name-{{ $vehicleCategory->id }}">Fleet Name/Type</label>
                            <input type="text" class="form-control" id="edit-name-{{ $vehicleCategory->id }}" name="name" value="{{ $vehicleCategory->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-size-{{ $vehicleCategory->id }}">Fleet Size</label>
                            <input type="number" class="form-control" id="edit-size-{{ $vehicleCategory->id }}" name="size" value="{{ $vehicleCategory->size }}" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-image-{{ $vehicleCategory->id }}">Fleet Icon</label>
                            <input type="file" class="form-control-file" id="edit-image-{{ $vehicleCategory->id }}" name="image">
                        </div>
                        <button type="submit" class="btn btn-success" id="edit-submitBtn-{{ $vehicleCategory->id }}">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@stop

@push('css')
    <link rel="stylesheet" href="/css/app.css">
@endpush

@push('js')

@endpush
