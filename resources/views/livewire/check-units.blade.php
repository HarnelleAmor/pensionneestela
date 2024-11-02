<div>
    <div class="mx-auto mb-3" x-data="{ checkLoading: false }"
        x-init="
            window.addEventListener('checkLoading-true', function(e) {
                checkLoading = false;
            });
        "
    >
        <form wire:submit="checkUnits(); checkLoading = true;">
            <script>
                function datePicker() {
                    const today = new Date().toISOString().split('T')[0];
                    
                    return {
                        today: today,
                        checkin: today,
                        
                        get minCheckoutDate() {
                            let checkoutMinDate = new Date(this.checkin);
                            checkoutMinDate.setDate(checkoutMinDate.getDate() + 1);
                            return checkoutMinDate.toISOString().split('T')[0];
                        },
                        
                        updateMinCheckout(event) {
                            this.checkin = event.target.value;
                        }
                    }
                }
            </script>
            <div x-data="datePicker()" class="row align-items-center justify-content-center g-2">
                <div class="col-6">
                    <label for="checkin" class="form-label fw-light mb-0 small fw-medium">Start Date</label>
                    <input type="date" class="form-control" id="checkin" name="check-in" wire:model="startDate" x-bind:min="today" x-on:input="updateMinCheckout" x-model="checkin" required>

                </div>
                <div class="col-6">
                    <label for="checkout" class="form-label fw-light mb-0 small fw-medium">End Date</label>
                    <input type="date" class="form-control" id="checkout" name="check-out" wire:model="endDate" x-bind:min="minCheckoutDate" required>

                </div>
                @error('startDate')
                    <div class="text-danger fst-italic small mt-1 text-center">
                        {{ $message }}
                    </div>
                @enderror
                @error('endDate')
                    <div class="text-danger fst-italic small mt-1 text-center">
                        {{ $message }}
                    </div>
                @enderror
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-sage px-4 fw-medium w-50 rounded-3">
                        <span x-show="checkLoading" style="display: none;"
                            class="spinner-border spinner-border-sm text-blackbean" role="status"
                            aria-hidden="true">
                        </span>
                        <span x-show="!checkLoading">Check</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="row justify-content-center align-items-start g-2">
        @foreach ($units_with_status as $unit)
            <div class="col-md-6">
                <div class="card rounded-3">
                    <img src="{{ asset($unit->photos->first()->photos_path) }}" alt="{{ $unit->name }} Image" class="img-fluid object-fit-cover rounded-top-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <div class="fs-4 fw-medium">{{ $unit->name }}</div>
                            @if ($unit->is_available)
                                <div class="badge text-bg-success fs-6 align-self-center">Available</div>
                            @else
                                <div class="badge text-bg-danger fs-6 align-self-center">Not Available</div>
                            @endif
                        </div>
                        <button class="btn btn-outline-darkgreen w-100 rounded-3 shadow-sm fw-medium mb-1" data-bs-toggle="modal" data-bs-target="#unitModal{{ $unit->id }}">View details</button>
                        <x-unit-modal :unit="$unit"/>
                        @if ($unit->is_available)
                                    <button type="button" class="btn btn-blackbean w-100 rounded-3 shadow-sm fw-medium"
                                        data-bs-toggle="modal" data-bs-target="#bookingModalMain{{$unit->id}}">Book this Unit</button>
                                    <div class="modal fade" id="bookingModalMain{{$unit->id}}" tabindex="-1" data-bs-backdrop="static"
                                        data-bs-keyboard="false" role="dialog" aria-labelledby="bookingModalMain{{$unit->id}}Label"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" x-data="{ advisoryCheck: true }">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="bookingModalMain{{$unit->id}}Label">
                                                        Booking Advisory
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-info" role="alert">
                                                        <ul>
                                                            <li class="fs-6 fw-medium lh-sm">To book a transient unit,
                                                                you have to secure a downpayment through
                                                                <strong>GCash</strong> with the indicated amount later
                                                                on in the booking form.</li>
                                                            <li class="fs-6 fw-medium lh-sm">You can only book 1
                                                                transient unit at a time.</li>
                                                        </ul>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6>Advisory</h6>
                                                        <ul>
                                                            <li>You are only given a limited time to complete the
                                                                booking process.
                                                            </li>
                                                            <li>You can prepare your GCash ahead for the down-payment.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="form-check mt-5">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="policyAgreementMain{{$unit->id}}"
                                                            x-on:click="advisoryCheck = !advisoryCheck" />
                                                        <label class="form-check-label" for="policyAgreementMain{{$unit->id}}"> I have
                                                            read and understand the advisory.</label>
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
                                                        <button type="submit" class="btn btn-blackbean rounded-3 shadow"
                                                            x-bind:disabled="advisoryCheck">Book Now</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-secondary w-100 rounded-0"
                                        @disabled(true)><svg xmlns="http://www.w3.org/2000/svg"
                                            width="18" height="18" fill="currentColor" class="bi bi-ban"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0" />
                                        </svg></button>
                                @endif
                        <div class="row justify-content-between g-2">
                            {{-- <div class="col-auto">
                                <div class="text-body-secondary fst-italic">{{ $no_of_nights }}
                                    {{ $no_of_nights == 1 ? 'night' : 'nights' }}</div>
                                <ul class="list-unstyled small mb-0 d-none d-sm-block">
                                    <li>{{ $unit->bed_config }}</li>
                                    <li>{{ $unit->occupancy_limit }} Guest Capacity</li>
                                    <li>Free Wifi</li>
                                </ul>
                                <button type="button" class="btn btn-outline-primary btn-sm border-0 p-0 px-1" data-bs-toggle="modal" data-bs-target="#unitModal{{ $unit->id }}">More details</button>
                                <x-unit-modal :unit="$unit"/>
                            </div>
                            <div class="col-auto align-self-end">
                                <div class="card d-inline-flex shadow d-none d-sm-block">
                                    <div class="card-body text-end">
                                        <p class="fw-medium mb-0">Price:
                                            &#8369;{{ number_format($unit->price_per_night * $no_of_nights, 2) }}</p>
                                        <small class="text-body-secondary mb-0">Per night:
                                            &#8369;{{ number_format($unit->price_per_night, 2) }}</small>
                                    </div>
                                </div>
                            </div> --}}
                            
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
