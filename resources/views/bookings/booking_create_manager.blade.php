@extends('layouts.manager')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Booking Form</h4>
            <form id="bookingForm" action="{{ route('booking.formStore') }}" method="post">
                @csrf
                <div class="row g-2">
                    <div class="col-md-3 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            value="{{ old('first_name') }}" />
                        @error('first_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            value="{{ old('last_name') }}" />
                        @error('last_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}" />
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="phone_no" class="form-label">Phone Number</label>
                        <input id="phone_no" class="form-control" type="text" pattern="\d*" required name="phone_no"
                            value="{{ old('phone_no') }}">
                        @error('phone_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="check-in" class="form-label">Check In</label>
                        <input id="check-in" class="form-control" type="date" required name="check_in"
                            value="{{ old('check_in', $checkin) }}" readonly>
                        @error('check_in')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="check-out" class="form-label">Check Out</label>
                        <input id="check-out" class="form-control" type="date" required name="check_out"
                            value="{{ old('check_out', $checkout) }}" readonly>
                        @error('check_out')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="no_of_guests" class="form-label">No. of Guests</label>
                        <input id="no_of_guests" class="form-control" type="number" min="1" required
                            name="no_of_guests" value="{{ old('no_of_guests') }}">
                        @error('no_of_guests')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <hr>

                <!-- Services Row -->
                <div class="row g-2">
                    <div class="col-12">
                        <h5>Services:</h5>
                    </div>
                    @foreach ($services as $service)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <div class="col input-group text-start">
                                            <div class="input-group-text">
                                                <input type="checkbox" class="form-check-input mt-0 service-check"
                                                    id="service_{{ $service->id }}" name="services[]"
                                                    value="{{ $service->id }}" @checked(old('services'))
                                                    onchange="toggleFields({{ $service->id }}, '{{ $service->name }}')"
                                                    data-service-name="{{ $service->name }}" />
                                            </div>
                                            <div class="input-group-text">
                                                <label class="form-check-label"
                                                    for="service_{{ $service->id }}">{{ $service->name }}</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            @if ($service->name != 'Meal Service')
                                                <div class="input-group">
                                                    <label class="input-group-text" for="quantity_{{ $service->id }}"
                                                        id="quantitylabel{{ $service->id }}">Quantity:</label>
                                                    <input class="form-control service-quantity"
                                                        id="quantity_{{ $service->id }}" type="number" name="quantity[]"
                                                        value="{{ old('quantity.' . $loop->index) }}"
                                                        aria-describedby="quantitylabel{{ $service->id }}"
                                                        placeholder="1-6" min="1" max="6"
                                                        @if (!old('services') || !in_array($service->id, old('services', []))) disabled @endif>
                                                </div>
                                            @else
                                                <input class="form-control service-quantity"
                                                    id="quantity_{{ $service->id }}" type="hidden" name="quantity[]"
                                                    value="1" />
                                            @endif
                                            <!-- Error for quantity -->
                                            @error('quantity.' . $loop->index)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Description -->
                                    <textarea class="form-control service-description" id="description_{{ $service->id }}" name="description[]"
                                        rows="3" @if (!old('services') || !in_array($service->id, old('services', []))) disabled @endif placeholder="Write the details here...">{{ old('description.' . $loop->index) }}</textarea>

                                    <!-- Error for description -->
                                    @error('description.' . $loop->index)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>

                .row.g2
                <div class="row justify-content-center mt-4">
                    <button type="submit" class="col-2 btn btn-primary">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('bookingForm').addEventListener('submit', function() {
            document.querySelectorAll('input[type=checkbox]').forEach(function(checkbox) {
                const serviceId = checkbox.value;
                const quantityInput = document.getElementById('quantity_' + serviceId);
                const descriptionInput = document.getElementById('description_' + serviceId);

                // If the checkbox is not checked, add hidden inputs with null values for both quantity and description
                if (!checkbox.checked) {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'services[]';
                    hiddenInput.value = null; // Set the value to null for unchecked checkboxes
                    checkbox.parentNode.appendChild(hiddenInput);

                    // Set the quantity input to null and append a hidden input for it
                    let hiddenQuantityInput = document.createElement('input');
                    hiddenQuantityInput.type = 'hidden';
                    hiddenQuantityInput.name = 'quantity[]';
                    hiddenQuantityInput.value = null;
                    quantityInput.parentNode.appendChild(hiddenQuantityInput);

                    // Set the description input to null and append a hidden input for it
                    let hiddenDescriptionInput = document.createElement('input');
                    hiddenDescriptionInput.type = 'hidden';
                    hiddenDescriptionInput.name = 'description[]';
                    hiddenDescriptionInput.value = null;
                    descriptionInput.parentNode.appendChild(hiddenDescriptionInput);
                }
            });
        });


        function toggleFields(serviceId, serviceName) {
            const checkbox = document.getElementById('service_' + serviceId);
            const quantityInput = document.getElementById('quantity_' + serviceId);
            const descriptionInput = document.getElementById('description_' + serviceId);

            if (checkbox.checked) {
                if (serviceName === 'Meal Service') {
                    quantityInput.value = 1;
                    descriptionInput.required = true;
                    descriptionInput.disabled = false;
                } else {
                    quantityInput.disabled = false;
                    quantityInput.required = true;

                    descriptionInput.disabled = false;
                    descriptionInput.required = false;
                }
            } else {
                // unchecked
                if (serviceName === 'Meal Service') {
                    descriptionInput.required = false;
                    descriptionInput.disabled = true;
                    descriptionInput.value = null;
                    quantityInput.value = null;
                    quantityInput.disabled = true;
                } else {
                    quantityInput.disabled = true;
                    quantityInput.required = false;
                    quantityInput.value = null;

                    descriptionInput.disabled = true;
                    descriptionInput.required = false;
                    descriptionInput.value = null;
                }
            }
        }

        // Ensure that the fields are toggled correctly when the page loads (for old values)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.service-check').forEach(function(checkbox) {
                const serviceId = checkbox.value;
                const serviceName = checkbox.getAttribute(
                    'data-service-name'); // Get the service name from the data attribute
                toggleFields(serviceId, serviceName);
            });
        });
    </script>
@endsection
