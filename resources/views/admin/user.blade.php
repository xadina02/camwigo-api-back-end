@extends('admin.layouts.app')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Users')
@section('content_header_subtitle', 'All')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <h1 class="m-0">
                @yield('content_header_title', 'Users')
                <small class="text-muted ml-2">
                    <i class="fas fa-xs fa-angle-right text-muted mx-1"></i>
                    @yield('content_header_subtitle', 'All')
                </small>
            </h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                <i class="fas fa-plus"></i> Create New User
            </button>
        </div>
    </div>
@stop

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
    
    @php
        $data = [];
        foreach ($allUsers as $user) {
            $btnView = '<a href="' . route('showUser', $user->id) . '" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>';
            $btnEdit = '<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal" data-id="' . $user->id . '" data-first_name="' . $user->first_name . '" data-last_name="' . $user->last_name . '" data-email="'. $user->email . '" data-phone="' . $user->phone . '" data-nin="' . $user->NIN . '">
                                <i class="fas fa-edit"></i> Edit
                            </button>';
            $btnDelete = '<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal" data-id="' . $user->id . '">
                                <i class="fas fa-trash"></i> Delete
                            </button>';

            $data[] = [
                $user->first_name ?? 'Not Found',
                $user->last_name ?? 'Not Found',
                $user->email ?? 'Not Found',
                $user->phone ?? 'Not Found',
                $user->NIN ?? 'Not Found',
                '<nobr>' . $btnView . ' ' . $btnEdit . $btnDelete . '</nobr>'
            ];
        }

        $heads = [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'National Identification Number',
            ['label' => 'Actions', 'no-export' => true, 'width' => 5],
        ];

        $config = [
            'data' => $data,
            'columns' => [null, null, null, null, null, ['orderable' => false]],
        ];
    @endphp
    <hr>
    @section('plugins.Datatables', true)
    <x-adminlte-datatable id="table1" :heads="$heads" head-theme="light" :config="$config"
        striped hoverable bordered compressed/>

    {{-- Create New User Modal --}}
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="userModalLabel">Create New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="vehicleCategoryForm" action="{{ route('createUser') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="NIN">NIN</label>
                            <input type="text" class="form-control" id="NIN" name="NIN" required>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="NIN">NIN</label>
                            <input type="text" class="form-control" id="nin" name="NIN">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
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
            // Initialize the DataTable
            $('#userTable').DataTable({
                responsive: true,
                autoWidth: false,
                // Add more DataTable options if needed
            });

            // Handle delete button click
            $('#deleteUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                var action = '{{ url("admin/user") }}/' + userId;
                $('#deleteUserForm').attr('action', action);
            });

            // Handle update button click
            $('#editUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                var firstName = button.data('first_name');
                var lastName = button.data('last_name');
                var email = button.data('email');
                var phone = button.data('phone');
                var nin = button.data('nin');

                var action = 'update/profile/' + userId;

                // Store the original values
                $('#editUserForm').data('original', {
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    phone: phone,
                    nin: nin
                });

                // Set form values
                $('#editUserForm #first_name').val(firstName);
                $('#editUserForm #last_name').val(lastName);
                $('#editUserForm #email').val(email);
                $('#editUserForm #phone').val(phone);
                $('#editUserForm #nin').val(nin);
                $('#editUserForm').attr('action', action);
            });

            // Submit handler to only submit changed fields
            $('#editUserForm').on('submit', function(event) {
                var form = $(this);
                var original = form.data('original');

                // Iterate through each form input and remove it if unchanged
                form.find('input').each(function() {
                    var input = $(this);
                    var name = input.attr('name');
                    var value = input.val().trim();

                    
                    // WHY IS NIN not forgotten?


                    if (value === original[name]) {
                        input.remove();
                    }
                });
            });
        });
    </script>
@endpush
