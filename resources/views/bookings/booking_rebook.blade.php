@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')

@section('content')
    <div class="container pt-2 mb-3">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-8 order-1 order-lg-1">
                <div class="card rounded-0">
                    <div class="card-body">
                        <h4 class="card-title text-center">Rescheduling Form</h4>
                        <div class="table-responsive">
                            <table class="table table-light table-bordered small">
                                <thead>
                                    <th colspan="2" class="text-center">Original Booking Details</th>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <th>Booking ID</th>
                                        <td>#{{ $booking->reference_no }}</td>
                                    </tr>
                                    <tr class="">
                                        <th>Status</th>
                                        <td>
                                            @switch($booking->status)
                                                @case('pending')
                                                    @if (!is_null($booking->reason_of_cancel))
                                                        <span class="badge text-bg-warning fw-normal text-wrap">Waiting for
                                                            cancellation
                                                            approval</span>
                                                    @else
                                                        <span class="badge text-bg-warning fw-normal">Pending</span>
                                                    @endif
                                                @break

                                                @case('confirmed')
                                                    @if (!is_null($booking->reason_of_cancel))
                                                        <span class="badge text-bg-warning fw-normal">Waiting for cancellation
                                                            approval</span>
                                                    @else
                                                        <span class="badge text-bg-success fw-normal">Confirmed</span>
                                                    @endif
                                                @break

                                                @case('checked-in')
                                                    <span class="badge text-bg-primary fw-normal">Checked-In</span>
                                                @break

                                                @case('checked-out')
                                                    <span class="badge text-bg-info fw-normal">Checked-Out</span>
                                                @break

                                                @case('no-show')
                                                    <span class="badge text-bg-secondary fw-normal">No Show</span>
                                                @break

                                                @case('cancelled')
                                                    <span class="badge text-bg-danger fw-normal">Cancelled</span>
                                                @break

                                                @default
                                                    <span class="badge text-bg-dark fw-normal">...</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <th>Name</th>
                                        <td>{{ $booking->first_name . ' ' . $booking->last_name }}</td>
                                    </tr>
                                    <tr class="">
                                        <th>Orginal Unit</th>
                                        <td>{{ $booking->unit->name }}</td>
                                    </tr>
                                    <tr class="">
                                        <th>Orginal Check-in Date</th>
                                        <td>{{ date('l - M j, Y', strtotime($booking->checkin_date)) }}</td>
                                    </tr>
                                    <tr class="">
                                        <th>Orginal Check-out Date</th>
                                        <td>{{ date('l - M j, Y', strtotime($booking->checkout_date)) }}</td>
                                    </tr>
                                    <tr class="">
                                        <th>Date Created</th>
                                        <td>{{ \Illuminate\Support\Carbon::parse($booking->created_at)->toDayDateTimeString() }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="bg-info-subtle text-blackbean py-2 px-3 small text-center mb-2">
                            Click the 'Check Unit' button to get the results of new inputs.
                        </div>
                        <livewire:check-unit-in-forms :booking="$booking->id" />
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
