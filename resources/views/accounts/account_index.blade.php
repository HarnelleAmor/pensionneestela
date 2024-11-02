@extends('layouts.manager')
@section('page', 'Accounts')
@section('content')
    <div class="container">
        <div class="card shadow-sm mt-2">
            <div class="card-header bg-darkgreen d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Manage Accounts</h5>
                <div>
                    <button type="button" class="btn btn-sage" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Add User
                    </button>
                </div>
            </div>
            <div class="card-body">
                <p>Total Number of Users: {{ $accounts->count() }}</p>
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
                                        <a href="{{ route('accounts.show', $account->id) }}" class="btn btn-darkgreen"><i class="bi bi-person-circle"></i> See Profile </a>
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
            $(document).ready(function () {
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
                <div class="modal-body">
                    <!-- Add User Form -->
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
                            <input type="text" pattern="\d*" class="form-control" id="phone"
                                placeholder="Enter Phone Number">
                        </div>
                        <div class="mb-3">
                            <label for="usertype" class="form-label">User Role</label>
                            <select class="form-select" name="usertype" id="usertype">
                                <option value="customer" selected>Customer</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add User</button>
                </div>
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
