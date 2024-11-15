@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')
@section('page', 'Unit Availability')
@section('content')
    <div class="container-fluid py-3">
        <div class="row justify-content-center align-items-center mb-3">
            <div class="col-lg-6">
                <div class="card card-body rounded-4 border-0 shadow">
                    <form method="GET" action="{{ route('unit.search') }}"
                        class="d-flex flex-wrap align-items-end justify-content-center">
                        <div class="me-md-2 mb-3">
                            <label for="checkin" class="form-label fw-light mb-0 small">Start Date</label>
                            <input type="date" class="form-control" id="checkin" name="check-in"
                                value="{{ old('check-in') }}" required>
                        </div>
                        <div class="me-md-2 mb-3">
                            <label for="checkout" class="form-label fw-light mb-0 small">End Date</label>
                            <input type="date" class="form-control" id="checkout" name="check-out"
                                value="{{ old('check-out') }}" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-blackbean">Check Units</button>
                        </div>
                    </form>
                    @if ($errors->checkavail->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->checkavail->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @isset($units_with_status)
            <div class="card mb-4 rounded-4">
                <div class="card-body">
                    <h3 class="card-title text-center">Search Results</h3>
                    <div class="row justify-content-center mb-3">
                        <div class="col-lg-6 col-md-8">
                            <div class="alert alert-info text-center">
                                <strong>Selected Dates:</strong> {{ $show_in }} - {{ $show_out }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center align-items-start g-2">
                        @foreach ($units_with_status as $unit)
                            <div class="col-lg-5 col-md-6">
                                <div class="card">
                                    <img src="{{ asset($unit->photos->first()->photos_path) }}" alt="{{ $unit->name }} Image"
                                        class="img-fluid">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="fs-4 fw-medium">{{ $unit->name }} | <span class="fs-5 text-body-secondary">{{$no_of_nights}} {{$no_of_nights == 1 ? 'night' : 'nights'}}</span></div>
                                            @if ($unit->is_available)
                                                <div class="badge text-bg-success align-self-start">Available</div>
                                            @else
                                                <div class="badge text-bg-danger align-self-start">Not Available</div>
                                            @endif
                                        </div>
                                        <div class="row justify-content-between g-2 mb-3">
                                            <div class="col-auto">
                                                <div class="text-body-secondary fst-italic">{{ $unit->view }}</div>
                                                <ul class="list-unstyled small">
                                                    <li>{{ $unit->bed_config }}</li>
                                                    <li>{{ $unit->occupancy_limit }} Guest Capacity</li>
                                                    <li>Free Wifi</li>
                                                </ul>
                                            </div>
                                            <div class="col-auto col-lg-6 col-md-12 align-self-end text-end">
                                                <div class="card d-inline-flex shadow">
                                                    <div class="card-body text-end">
                                                        <p class="fw-medium mb-0">Price: &#8369;{{ number_format($unit->price_per_night * $no_of_nights, 2) }}</p>
                                                        <small class="text-body-secondary mb-0">Per night: &#8369;{{ number_format($unit->price_per_night, 2) }}</small>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                        @if ($unit->is_available)
                                            <button type="button" class="btn btn-primary w-100 rounded-0"
                                                data-bs-toggle="modal" data-bs-target="#bookingModal">Book Unit</button>
                                            <div class="modal fade" id="bookingModal" tabindex="-1" data-bs-backdrop="static"
                                                data-bs-keyboard="false" role="dialog" aria-labelledby="bookingModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bookingModalLabel">
                                                                Booking Advisory
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-info" role="alert">
                                                                <ul>
                                                                    <li class="fs-6 fw-medium lh-sm">To book a transient unit,
                                                                        you
                                                                        have
                                                                        to
                                                                        secure a downpayment through <strong>GCash</strong> with
                                                                        the
                                                                        indicated amount later on in the booking form.</li>
                                                                    <li class="fs-6 fw-medium lh-sm">You can only book 1
                                                                        transient
                                                                        unit
                                                                        at a
                                                                        time.</li>
                                                                </ul>
                                                            </div>
                                                            <div class="mb-3">
                                                                <h6>Advisory</h6>
                                                                <ul>
                                                                    {{-- <li>You are only given a limited time to complete the
                                                                        booking
                                                                        process.
                                                                    </li> --}}
                                                                    <li>You can prepare your GCash ahead for the down-payment.</li>
                                                                </ul>
                                                            </div>
                                                            <div class="form-check mt-5">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="policyAgreement" onclick="toggleBookNowButton()" />
                                                                <label class="form-check-label" for="policyAgreement"> I have
                                                                    read
                                                                    and
                                                                    understand the advisory. </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('unit.selected') }}" method="post"
                                                                class="mb-0">
                                                                @csrf
                                                                <input type="hidden" name="unit_id"
                                                                    value="{{ $unit->id }}">
                                                                <input type="hidden" name="checkin"
                                                                    value="{{ $unit->checkin_date }}">
                                                                <input type="hidden" name="checkout"
                                                                    value="{{ $unit->checkout_date }}">
                                                                <button type="submit" id="bookNowButton"
                                                                    class="btn btn-primary" disabled>Book Now</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-secondary w-100 rounded-0" @disabled(true)><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
                                                <path d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
                                              </svg></button>
                                        @endif
                                    </div>
                                </div>
                                {{-- <div class="card h-100 d-flex flex-column">
                                    <img src="{{ asset($unit->photos->first()->photos_path) }}" alt="{{ $unit->name }} Image" class="img-fluid">
                                    <div class="card-body flex-grow-1"> <!-- This allows the body to take up available space -->
                                        <div class="d-flex justify-content-between">
                                            <div class="fs-4 fw-medium">{{ $unit->name }}</div>
                                            @if ($unit->is_available)
                                                <div class="badge text-bg-success align-self-start">Available</div>
                                            @else
                                                <div class="badge text-bg-danger align-self-start">Not Available</div>
                                            @endif
                                        </div>
                                        <div class="row justify-content-lg-between g-2">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="text-body-secondary fst-italic">{{ $unit->view }}</div>
                                                <ul class="list-unstyled">
                                                    <li>{{ $unit->bed_config }}</li>
                                                    <li>{{ $unit->occupancy_limit }} Guest Capacity</li>
                                                    <li>Free Wifi</li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-5 col-md-12">
                                                <div class="card rounded-0 border-0 shadow">
                                                    <div class="card-body text-end">
                                                        <p class="fw-medium mb-0">Price: &#8369;{{ number_format($unit->price_per_night * $no_of_nights, 2) }}</p>
                                                        <small class="text-body-secondary mb-0">Per night: &#8369;{{ number_format($unit->price_per_night, 2) }}</small>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                
                                    @if ($unit->is_available)
                                        <button type="button" class="btn btn-primary w-100 rounded-0 mt-auto" data-bs-toggle="modal" data-bs-target="#bookingModal">
                                            Book Now
                                        </button>
                                    @endif
                                </div> --}}
                                
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="col-md-8 d-flex flex-column justify-content-between">
                                    
                                    <div class="text-body-secondary">{{ $unit->view }}</div>
                                    <ul class="list-unstyled">
                                        <li>{{ $unit->bed_config }}</li>
                                        <li>{{ $unit->occupancy_limit }} Guest Capacity</li>
                                        <li>Free Wifi</li>
                                    </ul>
                                    @if ($unit->is_available)
                                        <button type="button" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal"
                                            data-bs-target="#bookingModal">Book Now</button>

                                        <div class="modal fade" id="bookingModal" tabindex="-1" data-bs-backdrop="static"
                                            data-bs-keyboard="false" role="dialog" aria-labelledby="bookingModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="bookingModalLabel">
                                                            Booking Advisory
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-info" role="alert">
                                                            <ul>
                                                                <li class="fs-6 fw-medium lh-sm">To book a transient unit, you
                                                                    have
                                                                    to
                                                                    secure a downpayment through <strong>GCash</strong> with the
                                                                    indicated amount later on in the booking form.</li>
                                                                <li class="fs-6 fw-medium lh-sm">You can only book 1 transient
                                                                    unit
                                                                    at a
                                                                    time.</li>
                                                            </ul>
                                                        </div>
                                                        <div class="mb-3">
                                                            <h6>Advisory</h6>
                                                            <ul>
                                                                <li>You are only given a limited time to complete the booking
                                                                    process.
                                                                </li>
                                                                <li>You can prepare you GCash for the down-payment.</li>
                                                            </ul>
                                                        </div>
                                                        <div class="form-check mt-5">
                                                            <input class="form-check-input" type="checkbox" id="policyAgreement"
                                                                onclick="toggleBookNowButton()" />
                                                            <label class="form-check-label" for="policyAgreement"> I have read
                                                                and
                                                                understand the advisory. </label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('unit.selected') }}" method="post"
                                                            class="mb-0">
                                                            @csrf
                                                            <input type="hidden" name="unit_id"
                                                                value="{{ $unit->id }}">
                                                            <input type="hidden" name="checkin"
                                                                value="{{ $unit->checkin_date }}">
                                                            <input type="hidden" name="checkout"
                                                                value="{{ $unit->checkout_date }}">
                                                            <button type="submit" id="bookNowButton" class="btn btn-primary"
                                                                disabled>Book Now</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div> --}}
                </div>
            </div>
        @endisset
    </div>
    <script>
        // Enable Book Now button
        function toggleBookNowButton() {
            const bookNowButton = document.getElementById('bookNowButton');
            const policyAgreement = document.getElementById('policyAgreement');
            bookNowButton.disabled = !policyAgreement.checked;
        }

        // Ensure check-in date is not in the past
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');

        // Set minimum date for check-in (today's date)
        checkinInput.setAttribute('min', today);

        // Add event listener to check-in date input
        checkinInput.addEventListener('change', function() {
            // Ensure checkout date is at least one day after check-in date
            const checkinDate = new Date(checkinInput.value);
            const checkoutMinDate = new Date(checkinDate);
            checkoutMinDate.setDate(checkinDate.getDate() + 1); // Add one day

            // Convert the checkoutMinDate to the format YYYY-MM-DD
            const checkoutMinDateStr = checkoutMinDate.toISOString().split('T')[0];

            // Set minimum checkout date to be at least one day after check-in
            checkoutInput.setAttribute('min', checkoutMinDateStr);
        });
    </script>
@endsection
