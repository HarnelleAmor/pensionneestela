@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="">{{ session('error') }}</div>
        </div>
    @endif

    <div class="row justify-content-center align-items-center g-2 my-3">
        <div class="col-lg-10 card rounded-0 shadow-lg">
            <div class="card-body m-3">
                <div class="row justify-content-between">
                    <div class="col text-start"><x-application-logo width="200" height="80" /></div>
                    <div class="col align-self-end">
                        <div class="text-end fs-3 fw-semibold">Booking Information</div>
                        <div class="text-end text-secondary fs-6"><i
                                class="bi bi-envelope-fill me-2"></i>pensionneestella@gmail.com</div>
                        <div class="text-end text-secondary fs-6"><i class="bi bi-telephone-fill me-2"></i>470-944-7433
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row g-2 mb-3">
                    <div class="col">
                        <div class="fs-5 fw-semibold">Booking Details</div>
                        <table class="w-100">
                            <tr>
                                <th>Booking ID</th>
                                <td class="ps-4"><span
                                        class="badge text-bg-info fs-6 fw-medium">#{{ $booking->reference_no }}</span></td>
                            </tr>
                            <tr>
                                <th>Check-in</th>
                                <td class="ps-4">{{ date('l, F j, Y', strtotime($booking->checkin_date)) }}
                                    {{ $booking->checkin_time != null ? '| ' . date('g:i A', strtotime($booking->checkin_time)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Check-out</th>
                                <td class="ps-4">{{ date('l, F j, Y', strtotime($booking->checkout_date)) }}
                                    {{ $booking->checkout_time != null ? '| ' . date('g:i A', strtotime($booking->checkout_time)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Guests</th>
                                <td class="ps-4">{{ $booking->no_of_guests }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td class="ps-4">{{ $booking->unit->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="ps-4">
                                    @switch($booking->status)
                                        @case('pending')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal">Waiting for cancellation
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
                            </tr>
                        </table>
                    </div>
                    <div class="col-3">
                        @if (Auth::user()->usertype == 'manager')
                            @if ($booking->status == 'pending' || $booking->status == 'confirmed')
                                @if ($booking->status == 'pending')
                                    <form action="{{ route('booking.confirm', $booking->id) }}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-primary mb-2 text-center">
                                            Confirm booking
                                        </button>
                                    </form>
                                    <a href="{{ route('rebooking.formCreate', $booking) }}" class="btn btn-outline-darkgreen btn-sm mb-2">Reschedule</a>
                                @endif
                                @if ($booking->status == 'confirmed')
                                    @if ($booking->checkin_date == now())
                                        <form action="{{ route('booking.checkin', $booking->id) }}" method="post">
                                            @method('PATCH')
                                            @csrf
                                            <button type="submit" class="btn btn-primary mb-2">
                                                Check in Guest/s
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('rebooking.formCreate', $booking) }}" class="btn btn-outline-darkgreen btn-sm mb-2">Reschedule</a>
                                    <form action="{{ route('booking.noshow', $booking->id) }}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-primary mb-2">
                                            No Show
                                        </button>
                                    </form>
                                @endif
                                @if ($booking->reason_of_cancel == null)
                                    <button class="btn btn-danger mb-2 text-center" data-bs-toggle="modal"
                                        data-bs-target="#cancelBookingModal{{ $booking->id }}">Cancel Booking</button>
                                    <!-- Cancel Booking Modal -->
                                    <div class="modal fade" id="cancelBookingModal{{ $booking->id }}" tabindex="-1"
                                        aria-labelledby="cancelBookingModal{{ $booking->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="cancelBookingModalLabel{{ $booking->id }}">
                                                        Are
                                                        you sure?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('booking.cancel', ['booking' => $booking->id]) }}">
                                                        @method('PATCH')
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="cancellation_reason" class="form-label">Customer's
                                                                reason:</label>
                                                            <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3" required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger">Proceed</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-primary mb-2">
                                            Confirm cancellation
                                        </button>
                                    </form>
                                @endif
                            @endif
                            @if ($booking->status == 'checked-in')
                                <form action="{{ route('booking.checkout', $booking->id) }}" method="post">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        Check out Guest/s
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>

                @if (!is_null($booking->reason_of_cancel))
                    <div class="mb-3">
                        Reason of cancel: {{ $booking->reason_of_cancel }}
                    </div>
                @endif

                <div class="row justify-content-between align-items-start g-4 mb-3">
                    <div class="col-md-7">
                        <div class="fs-5 fw-semibold">Booked By</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Name</div>
                                <div class="fw-normal">{{ $booking->first_name }} {{ $booking->last_name }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Email</div>
                                <div class="fw-normal">{{ $booking->email }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Phone Number</div>
                                <div class="fw-normal">{{ $booking->phone_no }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Booking Date</div>
                                <div class="fw-normal">{{ date('F j, Y g:i A', strtotime($booking->created_at)) }}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5">
                        @empty($booking->services)
                            <div class="fs-5 fw-semibold">
                                Services <small class="text-body-secondary">(No services availed)</small>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="fs-5 fw-semibold">Services</div>
                                    @if (
                                        ($booking->status == 'pending' || $booking->status == 'confirmed' || $booking->status == 'checked-in') &&
                                            is_null($booking->reason_of_cancel))
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditServices">Edit <i class="bi bi-pen"></i></button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="modalEditServices" tabindex="-1" role="dialog"
                                            aria-labelledby="modalServiceId" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen-sm-down" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalServiceId">Edit Services</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form id="updateServicesForm"
                                                        action="{{ route('booking.updateServices', $booking) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            @foreach ($services_availed as $service)
                                                                @if ($service['name'] === 'Meal Service')
                                                                    <div class="mb-3">
                                                                        <div class="form-check fs-5">
                                                                            <input class="form-check-input service-check"
                                                                                type="checkbox"
                                                                                id="service_{{ $service['id'] }}"
                                                                                name="service{{ $service['id'] }}"
                                                                                value="{{ $service['id'] }}"
                                                                                onchange="toggleFields({{ $service['id'] }}, '{{ $service['name'] }}')"
                                                                                data-service-name="{{ $service['name'] }}"
                                                                                @checked(old('service' . $service['id'], $service['is_checked'])) />
                                                                            <label class="form-check-label fw-medium"
                                                                                for="service_{{ $service['id'] }}">
                                                                                {{ $service['name'] }}
                                                                            </label>
                                                                        </div>
                                                                        <div class="">Base Cost:
                                                                            &#8369;{{ number_format($service['service_cost'], 2) }}<i
                                                                                class="bi bi-info-circle ms-2"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-title="This initial fee is subject to adjustment based on the meal request."></i>
                                                                        </div>
                                                                        <div class="fst-italic">
                                                                            <small>Request a <strong>home-cooked meal</strong> to be ready or delivered to your room during your stay. Let us know your preferences in the box below. For more inquiries, you may call us at <span class="text-decoration-underline">470-944-7433</span>.</small>
                                                                        </div>
                                                                        <input class="form-control service-quantity"
                                                                            id="quantity_{{ $service['id'] }}" type="hidden"
                                                                            name="quantity{{ $service['id'] }}"
                                                                            value="1" @disabled(!old('service' . $service['id'], $service['is_checked'])) />
                                                                        <textarea class="form-control service-description mt-2" id="description_{{ $service['id'] }}"
                                                                            name="description{{ $service['id'] }}" rows="3" @disabled(!old('service' . $service['id'], $service['is_checked']))
                                                                            placeholder="Let us know what meals you'd like and we'll cook it for you.">{{ old('description' . $service['id'], $service['details']) }}</textarea>
                                                                        @error('description.' . $service['id'])
                                                                            <small class="text-danger">{{ $message }}</small>
                                                                        @enderror
                                                                    </div>
                                                                @elseif ($service['name'] === 'Extra Bed Foam')
                                                                        <div class="row justify-content-between align-items-center mb-3">
                                                                            <div class="col-auto form-check fs-5">
                                                                                <input class="form-check-input service-check"
                                                                                    type="checkbox"
                                                                                    id="service_{{ $service['id'] }}"
                                                                                    name="service{{ $service['id'] }}"
                                                                                    value="{{ $service['id'] }}"
                                                                                    onchange="toggleFields({{ $service['id'] }}, '{{ $service['name'] }}')"
                                                                                    data-service-name="{{ $service['name'] }}"
                                                                                    @checked(old('service' . $service['id'], $service['is_checked'])) />
                                                                                <label class="form-check-label fw-medium"
                                                                                    for="service_{{ $service['id'] }}">
                                                                                    {{ $service['name'] }}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <div class="input-group d-flex flex-nowrap" data-bs-toggle="tooltip" data-bs-title="Each unit already includes 3 bed foams, one of which is foldable.">
                                                                                    <span class="input-group-text">Quantity:</span>
                                                                                    <input type="number" id="quantity_{{ $service['id'] }}"
                                                                                        name="quantity{{ $service['id'] }}" type="text"
                                                                                        class="form-control service-quantity text-center"
                                                                                        style="min-width: 50px; max-width: 55px"
                                                                                        value="{{ old('quantity' . $service['id'], $service['quantity']) }}"
                                                                                        aria-describedby="quantitylabel{{ $service['id'] }}"
                                                                                        min="1"
                                                                                        max="2"
                                                                                        @disabled(!old('service' . $service['id'], $service['is_checked'])) />
                                                                                    {{-- <button
                                                                                        id="quanbuttonmin_{{ $service['id'] }}"
                                                                                        class="btn btn-outline-secondary"
                                                                                        type="button"
                                                                                        @disabled(!old('service' . $service['id'], $service['is_checked']))
                                                                                        onclick="stepper({{ $service['id'] }}, 'minus')">-</button>
                                                                                    <input type="number"
                                                                                        id="quantity_{{ $service['id'] }}"
                                                                                        name="quantity{{ $service['id'] }}"
                                                                                        type="text"
                                                                                        class="form-control service-quantity text-center border border-dark-subtle border-top border-bottom"
                                                                                        style="min-width: 50px; max-width: 55px"
                                                                                        value="{{ old('quantity' . $service['id'], $service['quantity']) }}"
                                                                                        aria-describedby="quantitylabel{{ $service['id'] }}"
                                                                                        min="1"
                                                                                        @if ($service['name'] === 'Extra Bed Foam') max="2" @else max="6" @endif
                                                                                        @disabled(!old('service' . $service['id'], $service['is_checked'])) />
                                                                                    <button
                                                                                        id="quanbuttonmax_{{ $service['id'] }}"
                                                                                        class="btn btn-outline-secondary"
                                                                                        type="button"
                                                                                        @disabled(!old('service' . $service['id'], $service['is_checked']))
                                                                                        onclick="stepper({{ $service['id'] }}, 'plus')">+</button> --}}
                                                                                </div>
                                                                            </div>
                                                                            @error('quantity.' . $service['id'])
                                                                                <small
                                                                                    class="text-danger">{{ $message }}</small>
                                                                            @enderror
                                                                            <div class="">Base Cost:
                                                                                &#8369;{{ number_format($service['service_cost'], 2) }}
                                                                            </div>
                                                                            <div class="col-md-12 fst-italic">
                                                                                <small>You may request a <strong>maximum of 2</strong> extra bed
                                                                                    foams.</small>
                                                                            </div>
                                                                        </div>
                                                                @else
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <div class="col-auto form-check fs-5">
                                                                                <input class="form-check-input service-check"
                                                                                    type="checkbox"
                                                                                    id="service_{{ $service['id'] }}"
                                                                                    name="service{{ $service['id'] }}"
                                                                                    value="{{ $service['id'] }}"
                                                                                    onchange="toggleFields({{ $service['id'] }}, '{{ $service['name'] }}')"
                                                                                    data-service-name="{{ $service['name'] }}"
                                                                                    @checked(old('service' . $service['id'], $service['is_checked'])) />
                                                                                <label class="form-check-label fw-medium"
                                                                                    for="service_{{ $service['id'] }}">
                                                                                    {{ $service['name'] }}
                                                                                </label>
                                                                            </div>
                                                                            <div class="col-auto">
                                                                                <div class="input-group d-flex flex-nowrap" data-bs-toggle="tooltip" data-bs-title="Each unit already has 6 {{ strtolower($service['name']) }}.">
                                                                                    <span class="input-group-text">Quantity:</span>
                                                                                    <input type="number" id="quantity_{{ $service['id'] }}"
                                                                                        name="quantity{{ $service['id'] }}" type="text"
                                                                                        class="form-control service-quantity text-center"
                                                                                        style="min-width: 50px; max-width: 55px"
                                                                                        value="{{ old('quantity' . $service['id'], $service['quantity']) }}"
                                                                                        aria-describedby="quantitylabel{{ $service['id'] }}"
                                                                                        min="1"
                                                                                        max="3"
                                                                                        @disabled(!old('service' . $service['id'], $service['is_checked'])) />
                                                                                </div>
                                                                            </div>
                                                                            @error('quantity.' . $service['id'])
                                                                                <small
                                                                                    class="text-danger">{{ $message }}</small>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="">Base Cost:
                                                                            &#8369;{{ number_format($service['service_cost'], 2) }}
                                                                        </div>
                                                                        <div class="col-md-12 fst-italic">
                                                                            <small>Each unit already has 6
                                                                                {{ strtolower($service['name']) }}, but
                                                                                you can request a <strong>maximum of 3</strong>
                                                                                more. Specify the
                                                                                number of items needed by clicking the
                                                                                <strong>+</strong> or <strong>-</strong>
                                                                                buttons.</small>
                                                                        </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <ul class="">
                                        @foreach ($booking->services as $service)
                                            <li class="">
                                                @if ($service->name === 'Meal Service')
                                                    <div class="fw-normal">{{ $service->name }}</div>
                                                    <small
                                                        class="text-body-secondary fst-italic">"{{ $service->service->details }}"</small>
                                                @else
                                                    <div class="fw-normal">{{ $service->name }}
                                                        ({{ $service->service->quantity }}x)
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endempty
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fs-5 fw-semibold">
                        Payment Summary
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between align-items-start g-2">
                            <div class="col-md-7">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="fw-medium">Description</div>
                                        <div class="fw-medium">Amount</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <small>{{ $no_of_nights }} Night/s
                                            (&#8369;{{ number_format($booking->unit->price_per_night, 2) }})</small>
                                        <div class="fw-normal">
                                            &#8369;{{ number_format($booking->unit->price_per_night * $no_of_nights, 2) }}
                                        </div>
                                    </li>
                                    @foreach ($booking->services as $service)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <small>{{ $service->service->quantity }} {{ $service->name }}
                                                (&#8369;{{ number_format($service->service_cost, 2) }})
                                            </small>
                                            <div class="fw-normal">
                                                &#8369;{{ number_format($service->service_cost * $service->service->quantity, 2) }}
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item d-flex justify-content-end align-items-center">
                                        <div class="fw-semibold me-5">Total:</div>
                                        <div class="fw-semibold">&#8369;{{ number_format($booking->total_payment, 2) }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="alert alert-info" role="alert">
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="fw-semibold me-5">Down-paid</div>
                                            <div class="fw-semibold">&#8369;{{number_format(($booking->unit->price_per_night * $no_of_nights)/2, 2) }}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="fw-medium">
                                                Outstanding Balance<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-info-circle ms-2" data-bs-toggle="tooltip"
                                                    data-bs-title="Outstanding balances are paid during check-in or check-outs."
                                                    viewBox="0 0 16 16">
                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                                </svg>
                                            </div>
                                            <div class="fw-normal">&#8369;{{ number_format($booking->outstanding_payment, 2) }}</div>
                                        </li>
                                    </ul>
                                    <div>GCash Reference #: <span class="fw-medium">{{$booking->gcash_ref_no}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Section (Optional: Summary or Action Buttons) -->
                <div class="text-center">
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary mx-2">Back to Records</a>
                </div>
            </div>
        </div>
    </div>



    <script type="module">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <script>
        // Ensure that the fields are toggled correctly when the page loads (for old values)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.service-check').forEach(function(checkbox) {
                const serviceId = checkbox.value;
                const serviceName = checkbox.getAttribute(
                    'data-service-name'); // Get the service name from the data attribute
                toggleFields(serviceId, serviceName);
            });
            // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
            //     tooltipTriggerEl))
        });

        function toggleFields(serviceId, serviceName) {
            const checkbox = document.getElementById('service_' + serviceId);
            const quantityInput = document.getElementById('quantity_' + serviceId);
            const descriptionInput = document.getElementById('description_' + serviceId);

            if (checkbox.checked) {
                if (serviceName === 'Meal Service') {
                    quantityInput.value = 1;
                    quantityInput.disabled = false;
                    descriptionInput.required = true;
                    descriptionInput.disabled = false;
                } else {
                    quantityInput.disabled = false;
                    quantityInput.required = true;
                }
            } else {
                // unchecked
                if (serviceName === 'Meal Service') {
                    descriptionInput.required = false;
                    descriptionInput.disabled = true;
                    descriptionInput.value = null;
                    quantityInput.value = null;
                } else {
                    quantityInput.disabled = true;
                    quantityInput.required = false;
                    quantityInput.value = null;
                }
            }
        }
    </script>
@endsection
