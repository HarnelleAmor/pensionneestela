@extends('layouts.manager')
@section('page', 'Accounts')
@section('content')
    <div class="container pt-3 vh-100">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Edit User Information</h4>
                            <a href="{{ route('accounts.show', $account) }}" class="btn btn-sage">Go Back</a>
                        </div>

                        <form action="{{ route('accounts.update', $account) }}" method="post">
                            @csrf
                            @method('PATCH')

                            <div class="row justify-content-center align-items-center g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label mb-0">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            placeholder="Enter the first name"
                                            value="{{ old('first_name', $account->first_name) }}" required />
                                        @error('first_name')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label mb-0">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            placeholder="Enter the last name"
                                            value="{{ old('last_name', $account->last_name) }}" required />
                                        @error('last_name')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label mb-0">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Enter the email" value="{{ old('email', $account->email) }}"
                                            required />
                                        @error('email')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone_no" class="form-label mb-0">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_no" id="phone_no"
                                            placeholder="09•••••••••" pattern="\d*"
                                            value="{{ old('phone_no', $account->phone_no) }}" required />
                                        @error('phone_no')
                                            <small class="form-text text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-blackbean px-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
