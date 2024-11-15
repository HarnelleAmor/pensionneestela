@extends('layouts.manager')
@section('page', 'Accounts')
@section('content')
    <div class="container">
        <div class="card shadow-sm mt-2 mb-3">
            <div class="card-header bg-darkgreen d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Manage Accounts</h5>
                <div>
                    <button type="button" class="btn btn-sage" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Add User
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="d-flex justify-content-center">
                        <div class="d-inline-flex alert alert-danger">
                            <p class="mb-0 fw-medium">Form error:</p>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <p class="mb-0">Total Number of Users: {{ $accounts->count() }}</p>
                <!-- User Table -->
                <div class="table-responsive">
                    <table id="customers" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-nowrap">Name</th>
                                <th class="text-nowrap">Email</th>
                                <th class="text-nowrap">Phone Number</th>
                                <th class="text-nowrap">User Role</th>
                                <th class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td class="text-nowrap">{{ $account->first_name }} {{ $account->last_name }}</td>
                                    <td class="text-nowrap">{{ $account->email }}</td>
                                    <td class="text-nowrap text-center">
                                        @if ($account->phone_no)
                                            {{ $account->phone_no }}
                                        @else
                                            <small class="fst-italic text-muted">No number</small>
                                        @endif

                                    </td>
                                    <td class="text-nowrap">{{ ucfirst($account->usertype) }}</td>
                                    <td class="d-flex text-nowrap">
                                        <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-darkgreen"><i
                                                class="bi bi-person-circle"></i> See Profile </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                $('#customers').DataTable();
            });
        </script>
    @endpush

    {{-- <a href="{{ route('accounts.create') }}" class="btn btn-primary">Send Mail</a> --}}

    <!-- Modal for Adding a User -->
    <div class="modal fade" id="addUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('accounts.store') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="row justify-content-center align-items-center g-4 mb-3">
                            <div class="col-sm-6">
                                <label for="firstName" class="form-label mb-0">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name"
                                    placeholder="Enter First Name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="lastName" class="form-label mb-0">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name"
                                    placeholder="Enter Last Name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <label for="email" class="form-label mb-0">Email</label>
                                    <div class="form-check small">
                                        <input class="form-check-input" type="checkbox" value="1" id="verify_email" name="verify_email" {{ old('verify_email') == '1' ? 'checked' : '' }} />
                                        <label class="form-check-label text-secondary" for="verify_email"> Verify Now
                                        </label>
                                    </div>
                                </div>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter Email" value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="phone" class="form-label mb-0">Phone Number</label>
                                <input type="number" class="form-control" id="phone" name="phone_no"
                                    placeholder="Format: 09*********" value="{{ old('phone_no') }}" required>
                                @error('phone_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-8">
                                <label for="password" class="form-label mb-0">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required />
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="usertype" class="form-label mb-0">User Role</label>
                                <select class="form-select" name="usertype" id="usertype" required>
                                    <option value="customer" {{ old('usertype') == 'customer' ? 'selected' : '' }}>
                                        Customer
                                    </option>
                                    <option value="manager" {{ old('usertype') == 'manager' ? 'selected' : '' }}>
                                        Manager
                                    </option>
                                </select>
                                @error('usertype')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', 1) == 1 ? 'checked' : '' }} />
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-darkgreen">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <!-- Modal for Updating a User -->
        <div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Update User Form -->
                        <form>
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" placeholder="Enter First Name">
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter Email">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone"
                                    placeholder="Enter Phone Number">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div> --}}
@endsection
