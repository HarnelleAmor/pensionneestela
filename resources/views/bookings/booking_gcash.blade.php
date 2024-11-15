@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')

@section('content')
    <!-- Existing Booking Form Modal -->
    <div class="modal fade" id="existingBookForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="existingBookFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="existingBookFormLabel">Incomplete Booking Detected!</h1>
                </div>
                <div class="modal-body">
                    <p>It looks like you already have a booking in progress. <strong>You can only make one booking at a
                            time</strong>.</p>
                    <p>Please complete or discard your current booking before starting a new one.</p>
                    <p>What would you like to do?</p>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Current
                        Booking</button>
                    <form action="{{ route('unit.selected') }}" method="post">
                        @csrf
                        <input type="hidden" name="makeNewBookForm" value="1" />
                        <input type="hidden" name="unit_id" value="{{ old('unit_id') }}" />
                        <input type="hidden" name="checkin" value="{{ old('checkin') }}" />
                        <input type="hidden" name="checkout" value="{{ old('checkout') }}" />
                        <button type="submit" class="btn btn-danger no-unload-warning">Discard Current Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Leave Booking Confirmation Modal -->
    <div class="modal fade" id="leaveBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="leaveBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-danger">
                    <h5 class="modal-title" id="leaveBookingModalLabel">Leave Booking?</h5>
                </div>
                <div class="modal-body">
                    Your booking details will be disregarded. Are you sure you want to leave this page?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stay on Page</button>
                    <form action="{{ route('booking.deleteQueue') }}" method="post">
                        @csrf
                        <input type="hidden" name="destination" id="leaveDestination">
                        <button type="submit" class="btn btn-danger no-unload-warning" id="confirmLeave">Leave
                            Page</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row justify-content-center align-items-start">
            <div class="col-md-10 col-lg-8">
                <div class="card rounded-4 shadow">
                    <div class="card-body">
                        <div class="row justify-content-center align-items-start g-2 mb-3">
                            <div class="col-md-4">
                                <img src="{{ asset($unit_photo) }}" alt="Unit Image" class="img-fluid rounded shadow">
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between m-1">
                                    <div class="">
                                        <div class="fs-3 fw-semibold">{{ $selectedUnit->name }}</div>
                                        <div class="fw-medium">{{ date('F j', strtotime($booking->checkin_date)) }} -
                                            {{ date('j, Y', strtotime($booking->checkout_date)) }}</div>
                                        <div class="fw-medium text-body-secondary">{{ $booking->no_of_guests }} Guest(s)
                                        </div>
                                    </div>
                                    <div class="align-self-start">
                                        <a href="{{ route('booking.formCreate') }}"
                                            class="btn btn-primary icon-link icon-link-hover no-unload-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-arrow-left me-1" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                                                <use xlink:href="#arrow-left"></use>
                                            </svg>
                                            Modify
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center align-items-start g-4 mb-3">
                            <div class="col-md-5">
                                <div class="fs-5 fw-semibold">Personal Information</div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item fw-medium">
                                        <i class="bi bi-person me-2"></i>{{ $booking->first_name }}
                                        {{ $booking->last_name }}
                                    </li>
                                    <li class="list-group-item fw-medium">
                                        <i class="bi bi-envelope-at me-2"></i>{{ $booking->email }}
                                    </li>
                                    <li class="list-group-item fw-medium">
                                        <i class="bi bi-telephone me-2"></i>{{ $booking->phone_no }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                @empty($sessionServices)
                                    <div class="fs-5 fw-semibold">Requests <small class="text-body-secondary">(No services
                                            availed)</small>
                                    </div>
                                @else
                                    <div class="fs-5 fw-semibold">Requests</div>
                                    <ul class="">
                                        @foreach ($sessionServices as $item)
                                            <li class="">
                                                @if ($item['name'] === 'Meal Service')
                                                    <div class="fw-normal">{{ $item['name'] }}</div>
                                                    <small
                                                        class="text-body-secondary fst-italic">"{{ $item['details'] }}"</small>
                                                @else
                                                    <div class="fw-normal">{{ $item['name'] }} ({{ $item['quantity'] }}x)
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endempty
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="fs-5 fw-semibold">Fee Breakdown</div>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="fw-medium">Description</div>
                                        <div class="fw-medium">Amount</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <small>{{ $no_of_nights }} Night(s)
                                            (&#8369;{{ number_format($selectedUnit->price_per_night, 2) }})</small>
                                        <div class="fw-normal">
                                            &#8369;{{ number_format($selectedUnit->price_per_night * $no_of_nights, 2) }}
                                        </div>
                                    </li>
                                    @isset($sessionServices)
                                        @foreach ($sessionServices as $service)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <small>{{ $service['name'] == 'Meal Service' ? '' : $service['quantity'] }}
                                                    {{ $service['name'] }}
                                                    (&#8369;{{ number_format($service['cost'], 2) }})
                                                </small>
                                                <div class="fw-normal">&#8369;{{ number_format($service['service_cost'], 2) }}
                                                </div>
                                            </li>
                                        @endforeach
                                    @endisset
                                </ul>
                                <div class="d-flex justify-content-end align-items-start pe-3 mb-2">
                                    <table>
                                        <tr>
                                            <th>Total</th>
                                            <td class="fs-5 fw-medium">
                                                &#8369;{{ number_format($booking['total_payment'], 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="fs-5">Down Payment<i class="bi bi-info-circle fs-6 ms-2"
                                                    data-bs-toggle="tooltip" data-bs-title="GCash info below"></i></th>
                                            <td class="fs-4 fw-semibold">&#8369;{{ number_format($downpayment, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="pe-5">Outstanding Balance</th>
                                            <td class="fs-5 fw-normal">
                                                &#8369;{{ number_format($booking['total_payment'] - $downpayment, 2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="fst-italic text-muted">
                                    <small><i class="bi bi-info-square me-2 text-info"></i>You can pay the outstanding
                                        balances, including service costs, upon your check-in or check-out.</small>
                                </div>
                                <div class="">
                                    <small><i class="bi bi-info-square me-2 text-info"></i><strong>Down-payments</strong>
                                        must be paid through <span class="text-decoration-underline">GCash</span> through
                                        the details provided below.</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <h3 class="fw-semibold text-center">GCash Down Payment</h3>
                        <div class="row justify-content-center align-items-start g-2">
                            <div class="col-md-12">
                                <div class="alert alert-light d-flex align-items-center rounded-0 mb-0" role="alert">
                                    <i class="bi bi-info-circle-fill flex-shrink-0 me-3 text-info"></i>
                                    <div class="fw-medium">
                                        Open your GCash app and scan the QR-code provided below to pay your
                                        <strong>down-payment</strong>. Enter you transaction's reference number in the form
                                        to complete your booking.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-body text-center">
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-md-5">
                                            <img src="{{ asset('assets/images/GCash-MyQR.jpg') }}" class="img-fluid">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="fs-4 text-primary fw-bold mb-2">MA*Y A** G.</div>
                                            <div class="text-secondary fw-medium mb-1">Mobile No.:
                                                <span class="text-dark fw-semibold fs-5">0916-295-8090</span>
                                            </div>
                                            <div class="text-secondary fw-medium mb-5">User ID:
                                                <strong>&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;WHO9PW</strong>
                                            </div>
                                            <div class="fs-5">
                                                Amount to Pay: <span
                                                    class="fs-4 fw-bold">&#8369;{{ number_format($downpayment, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 text-center mt-3">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <div class="">{{ session('success') }}</div>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <div class="">{{ session('error') }}</div>
                                    </div>
                                @endif
                                @if (auth()->user()->usertype == 'manager')
                                    <form method="POST" action="{{ route('bookings.store') }}" x-data="{ cash: false, refNoValid: false }">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="cashCheck" class="form-check-label">Pay in Cash</label>
                                            <input id="cashCheck" type="checkbox" x-model="cash"
                                                class="form-check-input" />
                                        </div>

                                        <div class="mb-3" x-show="!cash">
                                            <label for="gcashRefNo" class="form-label fs-4 fw-medium">Transaction
                                                Reference Number</label>
                                            <input id="gcashRefNo" type="number"
                                                class="form-control border-bottom-only text-center"
                                                :name="cash ? '' : 'ref_no'"
                                                placeholder="Enter the reference number here..." min="0"
                                                x-bind:disabled="cash" x-bind:required="!cash"
                                                x-on:input="refNoValid = $event.target.value.length === 13" />
                                            <small id="helpId" class="form-text text-muted fst-italic">The GCash
                                                transaction number should be 13 digits.</small>
                                            @error('ref_no')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <input type="hidden" :name="cash ? 'ref_no' : ''" value="cash">
                                        <input type="hidden" name="privTerms" value="1">
                                        <button id="submitBtn" type="submit"
                                            class="btn btn-primary w-100 rounded-0 mt-2 mb-3"
                                            x-bind:disabled="!cash && !refNoValid">Proceed</button>
                                    </form>
                                @else
                                    <div x-data="{ ihaveread: true, refNoValid: false }">
                                        <form method="POST" action="{{ route('bookings.store') }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="gcashRefNo" class="form-label fs-4 fw-medium">Transaction
                                                    Reference Number</label>
                                                <input id="gcashRefNo" type="number"
                                                    class="form-control border-bottom-only text-center" name="ref_no"
                                                    aria-describedby="helpId"
                                                    placeholder="Enter the reference number here..." min="0"
                                                    pattern="\d+" value="{{ old('ref_no') }}" required
                                                    x-on:input="refNoValid = $event.target.value.length === 13" />
                                                <small id="helpId" class="form-text text-muted fst-italic">
                                                    The GCash transaction number should be 13 digits.
                                                </small>
                                                @error('ref_no')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="privTerms"
                                                    name="privTerms" required x-on:click="ihaveread = !ihaveread" />
                                                <small>
                                                    <label class="form-check-label" for="privTerms">
                                                        I have read and understood the <a
                                                            href="{{ route('privacy-policy') }}" target="_blank"
                                                            rel="noopener noreferrer">Privacy Policy</a> and <a
                                                            href="{{ route('terms-conditions') }}" target="_blank"
                                                            rel="noopener noreferrer">Terms & Conditions</a>.
                                                    </label>
                                                </small>
                                                @error('privTerms')
                                                    <div class="text-danger"><small>{{ $message }}</small></div>
                                                @enderror
                                            </div>
                                            <button id="submitBtn" type="submit"
                                                class="btn btn-blackbean w-100 rounded-3 mt-2 mb-3 fw-medium"
                                                x-bind:disabled="ihaveread || !refNoValid">Proceed</button>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <script type="module">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
            tooltipTriggerEl))
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store the URL where the user intends to go
            let intendedUrl = null;
            // Detect if a user tries to leave the page by clicking a link or button
            document.querySelectorAll('a[data-leave-check="true"], button[data-leave-check="true"]').forEach(
                function(element) {
                    element.addEventListener('click', function(e) {
                        e.preventDefault();
                        intendedUrl = element.href || element.dataset.url;
                        let leaveModal = new bootstrap.Modal(document.getElementById(
                            'leaveBookingModal'));
                        leaveModal.show();

                        const leaveHidden = document.getElementById('leaveDestination');
                        leaveHidden.value = intendedUrl;
                    });
                });

            // Optional: Prevent accidental tab/window close (beforeunload event)
            let isExempt = false;
            // window.addEventListener('beforeunload', function(e) {
            //     if (!isExempt) {
            //         // Show a confirmation dialog before leaving the page
            //         e.preventDefault();
            //         e.returnValue = ''; // Chrome requires returnValue to be set
            //     }
            // });

            // Exempt specific buttons from triggering the beforeunload event
            document.querySelectorAll('.no-unload-warning').forEach(function(button) {
                button.addEventListener('click', function() {
                    // Temporarily disable the unload warning
                    isExempt = true;
                });
            });
        });
    </script>
@endsection
