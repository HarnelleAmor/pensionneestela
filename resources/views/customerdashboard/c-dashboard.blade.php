{{-- @extends('layouts.customer')

@section('content')
    <div class="container-fluid mb-4">
        <div class="row justify-content-center align-items-start g-2 mb-2">
            <div class="col-md-6 ">
                <div class="card rounded-5 card-body">
                    <div class="d-flex justify-content-between">
                        <div class="fs-3 fw-semibold">Hello, {{ Auth::user()->first_name }}</div>
                        <a href="{{route('profile.edit')}}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square me-2" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                          </svg>See Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-md-3">
                <div class="row justify-content-start g-2">
                    <div class="col-md-12 col-sm-6 text-center align-items-center">
                        <a href="{{ route('showUnitCheckPage') }}"
                            class="btn btn-primary d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                class="bi bi-calendar2-plus" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                                <path
                                    d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM8 8a.5.5 0 0 1 .5.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8" />
                            </svg>
                            <span class="mt-1 fs-4 fw-semibold">Make a Booking</span>
                        </a>
                    </div>
                    <div class="col-md-12 col-sm-6 text-center">
                        <a href="{{ route('bookings.index') }}"
                            class="btn btn-primary d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                class="bi bi-clock-history" viewBox="0 0 16 16">
                                <path
                                    d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                <path
                                    d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                            </svg>
                            <span class="mt-1 fs-5 fw-semibold">View Booking History</span>
                        </a>
                    </div>
                    <div class="col-md-12 col-sm-6 text-center">
                        <a href="{{ route('bookings.index') }}"
                            class="btn btn-primary d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-view-stacked" viewBox="0 0 16 16">
                                <path d="M3 0h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm0 8h10a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2m0 1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                              </svg>
                            <span class="mt-1 fs-5 fw-semibold">View Units</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card rounded-5 vh-100 shadow-sm">
                    <div class="card-header text-bg-success rounded-top-5 text-center fs-2 fw-semibold">Upcoming Bookings
                    </div>
                    <div class="card-body">
                        <ul class="list-group overflow-y-auto">
                            @foreach ($upcoming_bookings as $booking)
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <div class="fs-5 fw-semibold">{{ $booking->unit->name }}</div>
                                        @if ($booking->status == 'pending' && is_null($booking->reason_of_cancel))
                                            <small class="badge text-bg-warning align-self-center">Pending</small>
                                        @elseif ($booking->status == 'confirmed' && is_null($booking->reason_of_cancel))
                                            <small class="badge text-bg-success align-self-center">Confirmed</small>
                                        @else
                                            <small class="badge text-bg-warning fw-normal align-self-center">Waiting for
                                                cancellation approval</small>
                                        @endif
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-auto d-block">
                                            <div class="">
                                                <span class="fw-medium">Date</span>:
                                                {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                            </div>
                                            @if (!empty($booking->services))
                                                <div class="">
                                                    <span class="fw-medium">Services</span>:
                                                </div>
                                                <ul style="list-style-type:disc;">
                                                    @foreach ($booking->services as $service)
                                                        <li>{{ $service->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-secondary fst-italic">No services availed.</div>
                                            @endif
                                            <a href="{{ route('bookings.show', $booking) }}"
                                                class="link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">More
                                                details</a>
                                        </div>
                                        <div class="col-auto align-self-end">
                                            @if (is_null($booking->reason_of_cancel))
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#cancelBookingModal{{ $booking->id }}">Cancel</button>
                                            @endif
                                        </div>
                                    </div>
                                </li>

                                <!-- Cancel Booking Modal-->
                                <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false"
                                    id="cancelBookingModal{{ $booking->id }}" tabindex="-1"
                                    aria-labelledby="cancelBookingModal{{ $booking->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-bg-warning">
                                                <h5 class="modal-title fw-bold">Are you sure?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fw-semibold">This action can't be undone.</div>
                                                <form method="POST"
                                                    action="{{ route('booking.cancel', ['booking' => $booking->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <textarea class="form-control" name="cancellation_reason" rows="3" placeholder="State your reason here..."
                                                        required></textarea>
                                                    <div class="mt-2 fw-medium"><strong>Note</strong>: If the purpose of
                                                        cancellation is for rebooking, please indicate it on the form.</div>
                                                    <div class="mt-1"><strong>Note</strong>: Please wait for the staff to
                                                        confirm your request. For inquiries, reach us out through:
                                                        <p class="mb-0 ps-3"><i class="bi bi-envelope-fill me-2"></i><a
                                                                href="mailto:pensionneestella@gmail.com"
                                                                class="link-offset-2 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">pensionneestella@gmail.com</a>
                                                        </p>
                                                        <p class="mb-0 ps-3"><i class="bi bi-telephone-fill me-2"></i><a
                                                                href="tel:470-944-7433"
                                                                class="link-offset-2 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">470-944-7433</a>
                                                        </p>
                                                    </div>
                                                    <div class="mt-2 d-flex">
                                                        <button type="submit"
                                                            class="btn btn-danger ms-auto">Cancel Booking</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>


            </div>
            <div class="col">
                <div class="card rounded-5" style="height: 20rem">
                    <div class="card-header rounded-top-5 text-bg-secondary text-center fs-4 fw-semibold">Notifications</div>
                    <div class="card-body">
                        <div class="p-3">
                            <h4 class="card-title fst-italic text-body-secondary text-center">No Notifications</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection --}}
@extends('layouts.customer')

@section('content')
    <div class="row g-2">
        <div class="col-lg-5">
            <div class="card rounded-4 shadow border-dark-subtle">
                <div class="card-body">
                    <h4 class="card-title text-center">Quick Unit Check</h4>
                    <livewire:check-units />
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card rounded-4 shadow">
                <div class="card-body overflow-auto px-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fs-4 fw-semibold">Your Upcoming Bookings</div>
                        <a href="{{route('bookings.index')}}" class="btn btn-outline-darkgreen btn-sm rounded-3 px-4">All Bookings</a>
                    </div>
                    <div class="table-responsive">
                        <table id="upcomingBookings" class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-nowrap">ID</th>
                                    <th scope="col" class="text-nowrap">Status</th>
                                    <th scope="col" class="text-nowrap">Unit</th>
                                    <th scope="col" class="text-nowrap">Check In</th>
                                    <th scope="col" class="text-nowrap">Check Out</th>
                                    <th scope="col" class="text-nowrap">Date Created</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($upcoming_bookings as $booking)
                                    <tr class="">
                                        <td class="text-nowrap">
                                            <a href="{{route('bookings.show', $booking)}}" class="text-decoration-none">
                                                #{{ $booking->reference_no }}
                                            </a>
                                        </td>
                                        <td class="text-nowrap">
                                            @if ($booking->status == 'pending' && is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning">Pending</span>
                                            @elseif ($booking->status == 'confirmed' && is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-success">Confirmed</span>
                                            @else
                                                <span class="badge text-bg-warning">Awaiting cancellation approval</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">{{ $booking->unit->name }}</td>
                                        <td class="text-nowrap">{{ date('M j, Y', strtotime($booking->checkin_date)) }}</td>
                                        <td class="text-nowrap">{{ date('M j, Y', strtotime($booking->checkout_date)) }}</td>
                                        <td class="text-nowrap">{{ date('h:i A - M j, Y', strtotime($booking->created_at)) }}</td>
                                        <td class="">
                                            @if (is_null($booking->reason_of_cancel))
                                                <button type="button" class="btn btn-primary btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#rebookBookingModal{{ $booking->id }}">Reschedule</button>
                                                <button class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#cancelBookingModal{{ $booking->id }}">
                                                    Cancel
                                                </button>
                                                <div class="modal fade" id="cancelBookingModal{{ $booking->id }}" tabindex="-1"
                                                    aria-labelledby="cancelBookingModal{{ $booking->id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h5 class="modal-title fw-bold">Are you sure?</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="fw-semibold">Bookings may be canceled. Please note that the downpayment is non-refundable. Guests have the option to reschedule their booking within a year. For more information, please refer to our <a href="{{ route('terms-conditions') }}" class="text-decoration-none">Terms and Conditions</a>.</p>
                                                                <form method="POST"
                                                                    action="{{ route('booking.cancel', ['booking' => $booking->id]) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <textarea class="form-control" name="cancellation_reason" rows="3" placeholder="State your reason here..."
                                                                        required></textarea>
                                                                    <small class="d-block mt-2">Your request will be checked by our staff and we'll notify you through your email provided in the booking form and/or your account's email.</small>
                                                                    <p class="mt-2">For inquiries, contact us through: <br>
                                                                        <a href="mailto:pensionneestella@gmail.com"
                                                                            class="link-primary">pensionneestella@gmail.com</a> <br>
                                                                        <a href="tel:470-944-7433" class="link-primary">470-944-7433</a>
                                                                    </p>
                                                                    <div class="d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn-darkgreen mt-2">Cancel this
                                                                        booking</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="rebookBookingModal{{ $booking->id }}" tabindex="-1"
                                                    aria-labelledby="rebookBookingModal{{ $booking->id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info">
                                                                <h5 class="modal-title fw-bold">Reschedule this booking?</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="fw-medium">Current bookings can be rescheduled within a year upon request to accommodate changes in plans.</p>
                                                                <p class="">Rescheduling is free, and is subject to available dates of each unit. The original downpayment will be transferred to the rescheduled booking. Any additional charges will be settled during time of check-in or check-out.</p>
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="{{route('rebooking.formCreate', $booking)}}" class="btn btn-darkgreen mt-2 px-4">Proceed</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>


                    {{-- <ul class="list-group">
                        @foreach ($upcoming_bookings as $booking)
                            <li class="list-group-item d-flex justify-content-between align-items-start shadow-sm mb-2">
                                <div>
                                    <div class="fs-5 fw-semibold">{{ $booking->unit->name }}</div>
                                    <small class="text-muted">{{ date('F j', strtotime($booking->checkin_date)) }} -
                                        {{ date('j, Y', strtotime($booking->checkout_date)) }}</small>
                                    @if (!empty($booking->services))
                                        <div><strong>Services:</strong></div>
                                        <ul class="ms-4">
                                            @foreach ($booking->services as $service)
                                                <li>{{ $service->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-secondary fst-italic">No services availed.</div>
                                    @endif
                                    <a href="{{ route('bookings.show', $booking) }}"
                                        class="link-primary text-decoration-none">More details</a>
                                </div>
                                <div class="text-end">
                                    @if ($booking->status == 'pending' && is_null($booking->reason_of_cancel))
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($booking->status == 'confirmed' && is_null($booking->reason_of_cancel))
                                        <span class="badge bg-success">Confirmed</span>
                                    @else
                                        <span class="badge bg-warning">Awaiting cancellation approval</span>
                                    @endif
                                    @if (is_null($booking->reason_of_cancel))
                                        <button class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal"
                                            data-bs-target="#cancelBookingModal{{ $booking->id }}">
                                            Cancel
                                        </button>
                                    @endif
                                </div>
                            </li>

                            <!-- Cancel Booking Modal-->
                            
                        @endforeach
                    </ul> --}}
                </div>
            </div>
        </div>
        <div class="col-4">

        </div>
    </div>
    @push('scripts')
        <script type="module">
            $(document).ready(function () {
                $('#upcomingBookings').DataTable({
                    scrollY: '50vh',
                });
            });
        </script>
    @endpush
@endsection
