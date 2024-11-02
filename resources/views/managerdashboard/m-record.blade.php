@extends('layouts.manager')

@section('content')

<!-- Search Criteria for bookings -->
<div class="container my-5">
    <div class="card shadow-sm p-4">
        <h4 class="text-center mb-4">Search Bookings</h4>
        <form method="GET" action="{{ route('record.search') }}">
            <div class="row">

                <!-- First or Last Name -->
                <div class="col-md-4 mb-3">
                    <label for="name">Customer Name (First or Last):</label>
                    <input type="text" class="form-control" id="name" placeholder="Input First or Last Name" name="name" value="{{ request('name') }}">
                </div>

                <!-- Booking Status -->
                <div class="col-md-4 mb-3">
                    <label for="status">Booking Status:</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked-in" {{ request('status') == 'checked-in' ? 'selected' : '' }}>Checked-in</option>
                        <option value="checked-out" {{ request('status') == 'checked-out' ? 'selected' : '' }}>Checked-out</option>
                        <option value="no-show" {{ request('status') == 'no-show' ? 'selected' : '' }}>No-show</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="unit_id">Unit:</label>
                    <select class="form-select" id="unit_id" name="unit_id">
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Email Search -->
                <div class="col-md-4 mb-3">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" placeholder="Input Email" name="email" value="{{ request('email') }}">
                </div>

                <!-- Check-in Date -->
                <div class="col-md-4 mb-3">
                    <label for="checkin_date">Check-in Date:</label>
                    <input type="date" class="form-control" id="checkin_date" name="start_date" value="{{ request('start_date') }}">
                </div>

                <!-- Check-out Date -->
                <div class="col-md-4 mb-3">
                    <label for="checkout_date">Check-out Date:</label>
                    <input type="date" class="form-control" id="checkout_date" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg">Search</button>
            </div>
        </form>
    </div>
</div>

<!-- Booking Table -->
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Booking Record</h5>
            <div>
                <form method="POST" action="{{ route('record.generate') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success me-2">Generate to PDF</button>
                </form>
                <form method="GET" target="_blank" action="{{ route('record.view') }}" class="d-inline">
                    <button type="submit" class="btn btn-info">View PDF</button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Status</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Number of Guests</th>
                            <th scope="col">Check-in Date</th>
                            <th scope="col">Check-out Date</th>
                            <th scope="col">Total Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filteredBookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge bg-{{ strtolower($booking->status) }}">{{ $booking->status }}</span></td>
                            <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->no_of_guests }}</td>
                            <td>{{ $booking->checkin_date }}</td>
                            <td>{{ $booking->checkout_date }}</td>
                            <td>{{ $booking->total_payment }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $filteredBookings->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Display total payment sum -->
<div class="container mt-3">
    <div class="alert alert-info">
        <strong>Total Payment Sum:</strong> ₱{{ number_format($totalPaymentSum, 2) }}
    </div>
</div>

@endsection