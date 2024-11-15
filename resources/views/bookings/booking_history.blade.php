@extends('layouts.customer')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h3 class="text-center fw-semibold text-uppercase">Your Booking Records</h3>
            <div class="table-responsive mt-4">
                @push('scripts')
                    <script type="module">
                        $(document).ready(function () {
                            $('#bookingsTable').DataTable();
                        });
                    </script>
                @endpush
                <table id="bookingsTable" class="table table-bordered table-striped text-center">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Name</th>
                            <th scope="col">Check-in Date</th>
                            <th scope="col">Check-out Date</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Guests</th>
                            <th scope="col">Total Payment</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->reference_no }}</td>
                                <td>
                                    @switch($booking->status)
                                        @case('pending')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal text-wrap">Waiting for cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-warning fs-6 fw-normal">Pending</span>
                                            @endif
                                        @break

                                        @case('confirmed')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal">Waiting for cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-success fs-6 fw-normal">Confirmed</span>
                                            @endif
                                        @break

                                        @case('checked-in')
                                            <span class="badge text-bg-primary fs-6 fw-normal">Checked-In</span>
                                        @break

                                        @case('checked-out')
                                            <span class="badge text-bg-info fs-6 fw-normal">Checked-Out</span>
                                        @break

                                        @case('no-show')
                                            <span class="badge text-bg-secondary fs-6 fw-normal">No Show</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge text-bg-danger fs-6 fw-normal">Cancelled</span>
                                        @break

                                        @default
                                            <span class="badge text-bg-dark fs-6 fw-normal">...</span>
                                    @endswitch
                                </td>
                                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                <td>{{ date('l, F j, Y', strtotime($booking->checkin_date)) }}</td>
                                <td>{{ date('l, F j, Y', strtotime($booking->checkout_date)) }}</td>
                                <td>{{ $booking->unit->name }}</td>
                                <td>{{ $booking->no_of_guests }}</td>
                                <td>&#8369;{{ $booking->total_payment }}</td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking) }}" class="">See Data</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7">No booking history</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
