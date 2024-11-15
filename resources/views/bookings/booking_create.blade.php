@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')
@if (auth()->user()->usertype == 'manager')
    @section('page', 'Booking Form')
@endif
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
    <!-- Existing Booking Form Modal -->
    <div class="modal fade" id="existingBookForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="existingBookFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-bg-warning">
                    <h1 class="modal-title fs-5" id="existingBookFormLabel">Incomplete Booking Detected!</h1>
                </div>
                <div class="modal-body">
                    <p>It looks like you already have a booking in progress. <strong>You can only make one booking at a
                            time</strong>.</p>
                    <p>Please complete or discard your current booking before starting a new one.</p>
                    <p>What would you like to do?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continue Current
                        Booking</button>
                    <form action="{{ route('unit.selected') }}" method="post">
                        @csrf
                        <input type="hidden" name="makeNewBookForm" value="1" />
                        <input type="hidden" name="unit_id" value="{{old('unit_id')}}" />
                        <input type="hidden" name="checkin" value="{{old('checkin')}}" />
                        <input type="hidden" name="checkout" value="{{old('checkout')}}" />
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
                    <form action="{{route('booking.deleteQueue')}}" method="post">
                        @csrf
                        <input type="hidden" name="destination" id="leaveDestination">
                        <button type="submit" class="btn btn-danger no-unload-warning" id="confirmLeave">Leave Page</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-start mb-3">
            <div class="col-md-10">
                <div class="card shadow">
                    <img src="{{ asset('assets/images/background.jpg') }}" class="card-img-top img-fluid"
                        style="object-fit: cover; max-height: 180px;" alt="Booking Form Image">
                    <div class="card-body px-5">

                        <div class="card-title fs-2 fw-medium text-center">Booking Form</div>
                        <div class="card-subtitle text-body-secondary text-center mb-4">Please fill up this form to book the unit.</div>

                        <form id="bookingForm" action="{{ route('booking.formStore') }}" method="post">
                            @csrf
                            <div class="row justify-content-center align-items-start g-4 mb-4">
                                <div class="col-md-3">
                                    <label for="first_name" class="form-label mb-0">First Name</label>
                                    <input id="first_name"
                                        class="form-control border-bottom-only @error('first_name') is-invalid @enderror"
                                        type="text" name="first_name"
                                        value="{{ old('first_name', $user->usertype === 'customer' ? $user->first_name : $booking->first_name) }}"
                                        required />
                                    @error('first_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="last_name" class="form-label mb-0">Last Name</label>
                                    <input id="last_name"
                                        class="form-control border-bottom-only @error('last_name') is-invalid @enderror"
                                        type="text" name="last_name"
                                        value="{{ old('last_name', $user->usertype === 'customer' ? $user->last_name : $booking->last_name) }}"
                                        required />
                                    @error('last_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_no" class="form-label mb-0">Phone Number</label>
                                    <input id="phone_no"
                                        class="form-control border-bottom-only @error('phone_no') is-invalid @enderror"
                                        type="number" name="phone_no" placeholder="09•••••••••"
                                        value="{{ old('phone_no', $user->usertype === 'customer' ? $user->phone_no : $booking->phone_no) }}"
                                        required />
                                    @error('phone_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label mb-0">Email</label>
                                    <input id="email"
                                        class="form-control border-bottom-only @error('email') is-invalid @enderror"
                                        type="text" name="email" placeholder="name@example.com"
                                        value="{{ old('email', $user->usertype === 'customer' ? $user->email : $booking->email) }}"
                                        required />
                                    <small class="text-muted fst-italic">We will be sending a confirmation of your booking
                                        through the email provided.</small>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="no_of_guests" class="form-label mb-0">Number of Guests<i
                                            class="bi bi-info-circle ms-2" data-bs-toggle="tooltip"
                                            data-bs-title="Minimum guest is 1, and maximum of 6."></i></label>
                                    <input id="no_of_guests"
                                        class="form-control border-bottom-only @error('no_of_guests') is-invalid @enderror"
                                        type="number" min="1" max="6" name="no_of_guests"
                                        value="{{ old('no_of_guests', $booking->no_of_guests) }}" required />
                                    <small class="text-muted fst-italic">Guests aged 7 years and older will be counted,
                                        while ages 6 and below will not be counted.</small>
                                    @error('no_of_guests')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-start g-5">
                                <div class="col-md-6">
                                    <div class="fs-4 fw-semibold">Services Offered</div>
                                    @foreach ($services as $service)
                                        <hr>
                                        @if ($service['name'] === 'Meal Service')
                                            <div class="mb-3">
                                                <div class="form-check fs-5">
                                                    <input class="form-check-input service-check" type="checkbox"
                                                        id="service_{{ $service['id'] }}"
                                                        name="service{{ $service['id'] }}" value="{{ $service['id'] }}"
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
                                                        class="bi bi-info-circle ms-2" data-bs-toggle="tooltip"
                                                        data-bs-title="This initial fee is subject to adjustment based on the meal request."></i>
                                                </div>
                                                <div class="fst-italic">
                                                    <small>Request a <strong>home-cooked meal</strong> to be ready or delivered to your room during your stay. Let us know your preferences in the box below. For more inquiries, you may call us at <span class="text-decoration-underline">470-944-7433</span>.</small>
                                                </div>
                                                <input class="form-control service-quantity"
                                                    id="quantity_{{ $service['id'] }}" type="hidden"
                                                    name="quantity{{ $service['id'] }}" value="1"
                                                    @disabled(!old('service' . $service['id'], $service['is_checked'])) />
                                                    <textarea class="form-control service-description mt-2" id="description_{{ $service['id'] }}"
                                                    name="description{{ $service['id'] }}" rows="3"
                                                    @disabled(!old('service' . $service['id'], $service['is_checked']))
                                                    placeholder="Let us know what meals you'd like and we'll cook it for you.">{{ old('description' . $service['id'], $service['details']) }}</textarea>
                                                @error('description.' . $service['id'])
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        @elseif ($service['name'] === 'Extra Bed Foam')
                                            <div class="row justify-content-between align-items-center mb-3">
                                                <div class="col-auto form-check fs-5">
                                                    <input class="form-check-input service-check" type="checkbox"
                                                        id="service_{{ $service['id'] }}"
                                                        name="service{{ $service['id'] }}" value="{{ $service['id'] }}"
                                                        onchange="toggleFields({{ $service['id'] }}, '{{ $service['name'] }}')"
                                                        data-service-name="{{ $service['name'] }}"
                                                        @checked(old('service' . $service['id'], $service['is_checked'])) />
                                                    <label class="form-check-label fw-medium"
                                                        for="service_{{ $service['id'] }}" data-bs-toggle="tooltip" data-bs-title="Each unit already includes 3 bed foams, one of which is foldable.">
                                                            {{ $service['name'] }}
                                                    </label>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group d-flex flex-nowrap" >
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
                                                    </div>
                                                </div>
                                                @error('quantity.' . $service['id'])
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <div class="">Base Cost:
                                                    &#8369;{{ number_format($service['service_cost'], 2) }}</div>
                                                <div class="col-md-12 fst-italic">
                                                    <small>You may request a <strong>maximum of 2</strong> extra bed
                                                        foams.</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row justify-content-between align-items-center mb-3">
                                                <div class="col-auto form-check fs-5">
                                                    <input class="form-check-input service-check" type="checkbox"
                                                        id="service_{{ $service['id'] }}"
                                                        name="service{{ $service['id'] }}" value="{{ $service['id'] }}"
                                                        onchange="toggleFields({{ $service['id'] }}, '{{ $service['name'] }}')"
                                                        data-service-name="{{ $service['name'] }}"
                                                        @checked(old('service' . $service['id'], $service['is_checked'])) />
                                                    <label class="form-check-label fw-medium" data-bs-toggle="tooltip" data-bs-title="Each unit already has 6 {{ strtolower($service['name']) }}."
                                                        for="service_{{ $service['id'] }}">
                                                        {{ $service['name'] }}
                                                    </label>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="input-group d-flex flex-nowrap">
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
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <div class="">Base Cost:
                                                    &#8369;{{ number_format($service['service_cost'], 2) }}</div>
                                                <div class="col-md-12 fst-italic">
                                                    <small>You can request a <strong>maximum of 3</strong> {{ strtolower($service['name']) }}.</small>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <div class="card rounded-0 shadow">
                                        <img src="{{ asset($unit_photo) }}" alt="Unit Image"
                                            class="card-img-top rounded-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="card-title fs-4 fw-medium">{{ $unit_selected->name }}</div>
                                                @if ($has_wifi)
                                                    <span class="badge text-bg-success fs-6 fw-normal align-self-end"><i
                                                            class="bi bi-wifi me-2"></i>Free Wifi</span>
                                                @endif
                                            </div>
                                            <table>
                                                <tr>
                                                    <th>Check-in</th>
                                                    <td class="ps-2">{{ date('F j, Y', strtotime($checkin)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Check-out</th>
                                                    <td class="ps-2">{{ date('F j, Y', strtotime($checkout)) }}</td>
                                                </tr>
                                            </table>
                                            <div class="text-body-secondary fst-italic">
                                                @if ($no_of_nights == 1)
                                                    <span>1 night</span>
                                                @else
                                                    <span>{{ $no_of_nights }} nights</span>
                                                @endif
                                                ({{ date('l', strtotime($checkin)) }} to
                                                {{ date('l', strtotime($checkout)) }})
                                            </div>
                                            <div class="mt-2 text-success"><span class="me-2"><x-bedroom-icon /></span>
                                                {{ $unit_selected->bed_config }}</div>
                                            <div class="text-success"><span class="me-2 text-dark"><i
                                                        class="bi bi-arrow-down-up"></i></span>
                                                {{ $unit_selected->location }}</div>
                                            @foreach ($unit_selected->amenities as $unit_amenity)
                                                @if ($unit_amenity->amenity->highlight && !($unit_amenity->name === 'Free Wifi'))
                                                    <div class="text-success">
                                                        <span class="me-2 text-dark">
                                                            @component('components.' . $unit_amenity->icon)
                                                            @endcomponent
                                                        </span> {{ $unit_amenity->name }}
                                                    </div>
                                                @endif
                                            @endforeach
                                            <hr>
                                            <div class="d-flex justify-content-between fw-medium">
                                                <div>Room Price (per night)</div>
                                                <span>&#8369;{{ number_format($unit_selected->price_per_night, 2) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between fw-medium">
                                                <div>Tentative Total Payment</div>
                                                <span>&#8369;{{ number_format($unit_selected->price_per_night * $no_of_nights, 2) }}</span>
                                            </div>
                                            <small class="fst-italic text-secondary">Fees of services availed are not yet included.</small>
                                            <div class="alert alert-info rounded-0 mt-3" role="alert">
                                                <div class="fs-5 fw-semibold">Down Payment &#8369;{{ number_format(($unit_selected->price_per_night * $no_of_nights) / 2, 2) }}</div>
                                                <small class="fst-italic text-secondary">The down-payment method will be shown
                                                    in the next form. Please prepare your GCash.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center mt-5 mb-3">
                                <button type="submit" class="btn btn-primary icon-link icon-link-hover text-center d-flex align-items-center justify-content-center fs-5 no-unload-warning" data-no-leave-confirmation="true">
                                    Proceed to Payment<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-arrow-right ms-1" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>




    @if (session('queue_exists'))
        <script type="module">
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    let modalElement = document.getElementById('existingBookForm');
                    let myModal = new bootstrap.Modal(modalElement);
                    myModal.show();
                }, 500); // 2000 milliseconds = 2 seconds delay
            });
        </script>
    @endif


    <script type="module">
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(
            tooltipTriggerEl))
    </script>

    <script>
        // Store the URL where the user intends to go
        let intendedUrl = null;
        // Detect if a user tries to leave the page by clicking a link or button
        document.querySelectorAll('a[data-leave-check="true"], button[data-leave-check="true"]').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                intendedUrl = element.href || element.dataset.url;
                let leaveModal = new bootstrap.Modal(document.getElementById('leaveBookingModal'));
                leaveModal.show();

                const leaveHidden = document.getElementById('leaveDestination');
                leaveHidden.value = intendedUrl;
            });
        });

        // Optional: Prevent accidental tab/window close (beforeunload event)
        let isExempt = false;
        window.addEventListener('beforeunload', function(e) {
            if (!isExempt) {
                // Show a confirmation dialog before leaving the page
                e.preventDefault();
                e.returnValue = ''; // Chrome requires returnValue to be set

            }
        });

        // Exempt specific buttons from triggering the beforeunload event
        document.querySelectorAll('.no-unload-warning').forEach(function (button) {
            button.addEventListener('click', function () {
                // Temporarily disable the unload warning
                isExempt = true;
            });
        });

        // Ensure that the fields are toggled correctly when the page loads (for old values)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.service-check').forEach(function(checkbox) {
                const serviceId = checkbox.value;
                const serviceName = checkbox.getAttribute(
                    'data-service-name'); // Get the service name from the data attribute
                toggleFields(serviceId, serviceName);
            });
        });

        function stepper(id, action) {
            let input = document.getElementById('quantity_' + id);
            let currentValue = parseInt(input.value);
            let min = parseInt(input.min);
            let max = parseInt(input.max);

            if (isNaN(currentValue)) {
                currentValue = 0;
            }

            if (action === 'minus' && currentValue > min) {
                input.value = currentValue - 1;
            }
            if (action === 'plus' && currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function toggleFields(serviceId, serviceName) {
            const checkbox = document.getElementById('service_' + serviceId);
            const quantityInput = document.getElementById('quantity_' + serviceId);
            const quanButtonMin = document.getElementById('quanbuttonmin_' + serviceId);
            const quanButtonMax = document.getElementById('quanbuttonmax_' + serviceId);
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
                    quanButtonMin.disabled = false;
                    quanButtonMax.disabled = false;
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
                    quanButtonMin.disabled = true;
                    quanButtonMax.disabled = true;
                }
            }
        }
    </script>
@endsection
