<div x-data="{ unitName: '', unitInfo: false }" class="mb-3">
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
    <div class="row justify-content-between align-items-start g-2 mb-3">
        <div class="col-lg-4">
            <div class="mb-2" x-data="datePicker()">
                <form wire:submit="checkUnits">
                    <div class="row justify-content-center align-items-end g-2">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-6">
                            <label for="checkin" class="form-label mb-0 small">Start Date</label>
                            <input type="date" class="form-control form-control-sm" id="checkin"
                                wire:model="startDate" x-bind:min="today" x-on:input="updateMinCheckout"
                                x-model="checkin" required />
                            @error('startDate')
                                <small class="text-danger fst-italic">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-4 col-sm-4 col-6">
                            <label for="checkout" class="form-label mb-0 small">End Date</label>
                            <input type="date" class="form-control form-control-sm" id="checkout"
                                wire:model="endDate" x-bind:min="minCheckoutDate" required>
                            @error('endDate')
                                <small class="text-danger fst-italic">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-4 col-sm-4 col-6">
                            <button type="submit" class="btn btn-darkgreen btn-sm w-100">
                                <span class="spinner-border spinner-border-sm text-sage me-1" wire:loading></span>Check
                                Units
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <p class="mb-0 fw-medium text-end">{{ $date_selected }}</p>
            <p class="small text-end">{{ $days_selected }}</p>
            <p class="mb-0">Select Unit:</p>
            <div class="row justify-content-end align-items-start g-2">
                @foreach ($units_with_status as $unit)
                    <div class="col-6">
                        @if ($unit->is_available)
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" value="{{ $unit->id }}"
                                    id="unit{{ $unit->id }}" name="unit" x-data="{
                                        updateInputs() {
                                            $wire.test();
                                            $('#rebook_checkin').val($wire.checkin_selected);
                                            $('#rebook_checkout').val($wire.checkout_selected);
                                            $('#rebook_unit').val($wire.unit_selected->id);
                                            
                                            $('.newDateUnit').text('{{date('M j', strtotime($checkin_selected)) . ' - ' . date('j, Y', strtotime($checkout_selected))}} | $wire.unit_selected->name');
                                        }
                                    }"
                                    x-on:click="unitName = '{{ $unit->name }}'; unitInfo = true; $wire.set('checkin_selected', , false)">
                                <label class="form-check-label text-success" for="unit{{ $unit->id }}">
                                    {{ $unit->name }}
                                </label>
                            </div> --}}
                            <button type="button" class="btn btn-outline-darkgreen btn-sm w-100" data-bs-toggle="modal"
                                data-bs-target="#confirmUnitModal{{ $unit->id }}">
                                {{ $unit->name }}
                            </button>

                            <div class="modal fade" id="confirmUnitModal{{ $unit->id }}" tabindex="-1"
                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                aria-labelledby="chooseUnitTitle{{ $unit->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="chooseUnitTitle{{ $unit->id }}">
                                                Choose this Unit?
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fs-4 fw-medium">{{ $unit->name }} | <span
                                                        class="fs-5 text-body-secondary">{{ $no_of_nights }}
                                                        {{ $no_of_nights == 1 ? 'night' : 'nights' }}</span></div>
                                                @if ($unit->is_available)
                                                    <div class="badge text-bg-success">Available</div>
                                                @else
                                                    <div class="badge text-bg-danger">Not Available</div>
                                                @endif
                                            </div>
                                            <div class="row justify-content-between g-2">
                                                <div class="col-sm-6">
                                                    <div class="d-inline-flex ms-auto">
                                                        <button type="button" class="btn btn-sage btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#unitDetails{{ $unit->id }}">
                                                            See Unit details
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="card border-0 text-bg-darkgreen">
                                                        <div class="card-body py-1 d-flex align-items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                                                <path
                                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                                            </svg>
                                                            <div class="">
                                                                <p class="mb-0 fw-semibold">New selected Date and Unit
                                                                </p>
                                                                <p class="mb-0 fw-medium small">{{ $date_selected }} |
                                                                    {{ $days_selected }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered small">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="3" class="text-center">Billing
                                                                        Details</th>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col"></th>
                                                                    <th scope="col">Old</th>
                                                                    <th scope="col">New</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="">
                                                                    <td>{{ \Illuminate\Support\Carbon::parse($booking->checkin_date)->diffInDays(\Illuminate\Support\Carbon::parse($booking->checkout_date)) }}
                                                                        Night/s
                                                                        (&#8369;{{ number_format($booking->unit->price_per_night, 2) }})
                                                                    </td>
                                                                    <td>
                                                                        &#8369;{{ number_format($booking->unit->price_per_night * \Illuminate\Support\Carbon::parse($booking->checkin_date)->diffInDays(\Illuminate\Support\Carbon::parse($booking->checkout_date)), 2) }}
                                                                    </td>
                                                                    <td>
                                                                        &#8369;{{ number_format($booking->unit->price_per_night * $no_of_nights, 2) }}
                                                                    </td>
                                                                </tr>
                                                                @foreach ($booking->services as $service)
                                                                    <tr>
                                                                        <td>{{ $service->service->quantity }}
                                                                            {{ $service->name }}
                                                                            (&#8369;{{ number_format($service->service_cost, 2) }})
                                                                        </td>
                                                                        <td colspan="2" class="text-center">
                                                                            &#8369;{{ number_format($service->service_cost * $service->service->quantity, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                <tr class="">
                                                                    <td class="bg-primary-subtle">Total Payment</td>
                                                                    <td class="bg-primary-subtle text-center">
                                                                        &#8369;{{ number_format($booking->total_payment, 2) }}
                                                                    </td>
                                                                    <td
                                                                        class="bg-primary-subtle text-center fw-semibold">
                                                                        &#8369;{{ number_format($new_total_payment, 2) }}
                                                                    </td>
                                                                </tr>
                                                                <tr class="">
                                                                    <td>Down-paid Amount</td>
                                                                    <td colspan="2" class="text-center">
                                                                        &#8369;{{ number_format($booking->total_payment - $booking->outstanding_payment, 2) }}
                                                                    </td>
                                                                    {{-- <td>...</td> --}}
                                                                </tr>
                                                                <tr class="">
                                                                    <td>Outstanding Balance</td>
                                                                    <td>&#8369;{{ number_format($booking->outstanding_payment, 2) }}
                                                                    </td>
                                                                    <td>&#8369;{{ number_format($new_outstanding_payment < 0 ? 0.0 : $new_outstanding_payment, 2) }}
                                                                    </td>
                                                                </tr>
                                                                @if ($new_outstanding_payment < 0)
                                                                    <tr>
                                                                        <td class="bg-warning-subtle">Overpayment</td>
                                                                        <td colspan="2"
                                                                            class="bg-warning-subtle text-center">
                                                                            &#8369;{{ number_format(abs($new_outstanding_payment), 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-info d-flex gap-2 small" role="alert">
                                                        <div class="">
                                                            <i class="bi bi-info-circle-fill"></i>
                                                        </div>
                                                        <p class="mb-0">Any overpayment resulting from the rescheduling process will be refunded to the guest upon check-in.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <form action="{{ route('rebooking.formStore', $booking->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="new_unit" value="{{ $unit->id }}">
                                                <input type="hidden" name="new_checkin"
                                                    value="{{ $unit->checkin_date }}">
                                                <input type="hidden" name="new_checkout"
                                                    value="{{ $unit->checkout_date }}">
                                                <button type="submit" class="btn btn-blackbean">Submit</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="unitDetails{{ $unit->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="unitModaTitleId{{ $unit->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content text-blackbean">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="unitModaTitleId{{ $unit->id }}">
                                                <span x-text="unitName"></span> Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-toggle="modal"
                                                data-bs-target="#confirmUnitModal{{ $unit->id }}"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row justify-content-between">
                                                <div class="col">
                                                    <h3 class="unit-title">{{ $unit->name }}</h3>
                                                    <h6 class="card-subtitle text-body-secondary">{{ $unit->view }}
                                                    </h6>
                                                </div>
                                                @isset($unit->is_available)
                                                    <div class="col align-self-center text-end">
                                                        @if ($unit->is_available)
                                                            <p class="status text-success fs-5"><i
                                                                    class="bi bi-calendar2-check-fill"></i>
                                                                Available </p>
                                                        @else
                                                            <p class="status text-danger fs-5"><i
                                                                    class="bi bi-calendar2-x-fill"></i>
                                                                Not Available
                                                            </p>
                                                        @endif
                                                    </div>
                                                @endisset
                                            </div>
                                            <div class="row g-2 my-3">
                                                <div class="col-5 fw-medium ps-2">
                                                    <div class=""><x-bedroom-icon /> {{ $unit->bed_config }}
                                                    </div>
                                                    <div class=""><i class="bi bi-people-fill"></i>
                                                        {{ $unit->occupancy_limit }} Guest Capacity</div>
                                                    @foreach ($unit->amenities as $unit_amenity)
                                                        @if ($unit_amenity->amenity->highlight)
                                                            <div class="">
                                                                @component('components.' . $unit_amenity->icon)
                                                                @endcomponent {{ $unit_amenity->name }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="col-7">
                                                    <div id="modalImages{{ $unit->id }}" class="carousel slide">
                                                        <div class="carousel-inner rounded-3" role="listbox">
                                                            @foreach ($unit->photos as $photo)
                                                                <div
                                                                    class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                    <img src="{{ asset($photo->photos_path) }}"
                                                                        class="w-100 d-block img-fluid object-fit-cover rounded-3"
                                                                        alt="{{ $unit->name }} Image"
                                                                        style="height: 250px" />
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button class="carousel-control-prev" type="button"
                                                            data-bs-target="#modalImages{{ $unit->id }}"
                                                            data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Previous</span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button"
                                                            data-bs-target="#modalImages{{ $unit->id }}"
                                                            data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                aria-hidden="true"></span>
                                                            <span class="visually-hidden">Next</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 fs-4 fw-semibold my-3">Unit Amenities</div>
                                                <div class="col-md-6">
                                                    <h5><x-bathroom-icon /> Bathroom</h5>
                                                    <ul>
                                                        @foreach ($unit->amenities as $unit_amenity)
                                                            @if ($unit_amenity->category == 'bathroom')
                                                                <li class="list-group-item">
                                                                    @component('components.' . $unit_amenity->icon)
                                                                    @endcomponent {{ $unit_amenity->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <h5><i class="bi bi-check-lg"></i> Comforts & Entertainment</h5>
                                                    <ul>
                                                        @foreach ($unit->amenities as $unit_amenity)
                                                            @if ($unit_amenity->category == 'comforts')
                                                                <li class="list-group-item">
                                                                    @component('components.' . $unit_amenity->icon)
                                                                    @endcomponent {{ $unit_amenity->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <h5><x-bedroom-icon /> Bedroom</h5>
                                                    <ul>
                                                        @foreach ($unit->amenities as $unit_amenity)
                                                            @if ($unit_amenity->category == 'bedroom')
                                                                <li class="list-group-item">
                                                                    @component('components.' . $unit_amenity->icon)
                                                                    @endcomponent {{ $unit_amenity->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <h5><x-kitchen-icon /> Kitchen</h5>
                                                    <ul>
                                                        @foreach ($unit->amenities as $unit_amenity)
                                                            @if ($unit_amenity->category == 'kitchen')
                                                                <li class="list-group-item">
                                                                    @component('components.' . $unit_amenity->icon)
                                                                    @endcomponent {{ $unit_amenity->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <h5><i class="bi bi-plus-lg"></i> More</h5>
                                                    <ul>
                                                        @foreach ($unit->amenities as $unit_amenity)
                                                            @if ($unit_amenity->category == 'more')
                                                                <li class="list-group-item">
                                                                    @component('components.' . $unit_amenity->icon)
                                                                    @endcomponent {{ $unit_amenity->name }}
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="row justify-content-between border rounded-3 py-2">
                                                <div class="col align-self-center text-start">
                                                    <p class="fs-5 fw-medium mb-0">Price:<span
                                                            class="ms-2">&#8369;{{ number_format($unit->price_per_night) }}</span>
                                                    </p>
                                                    <p class="fs-6 text-body-secondary mb-0">Per night excluding
                                                        service charges</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" value="{{ $unit->id }}"
                                    id="unit{{ $unit->id }}" x-data x-bind:checked="false"
                                    name="unit" disabled>
                                <label class="form-check-label text-danger" for="unit{{ $unit->id }}">
                                    {{ $unit->name }}
                                </label>
                            </div> --}}
                            <button type="button" class="btn btn-outline-danger btn-sm w-100" disabled>
                                {{ $unit->name }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- @foreach ($units_with_status as $unit)
        <div class="card border-0 text-bg-blackbean" x-show="unitInfo && unitName == '{{ $unit->name }}'"
            style="display: none">
            <div class="card-body py-1 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-calendar-check" viewBox="0 0 16 16">
                        <path
                            d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                    </svg>
                    <div class="">
                        <p class="mb-0 fw-semibold small">New selected Date and Unit</p>
                        <p class="mb-0 fw-medium small newDateUnit"></p>
                    </div>
                </div>
                <button type="button" class="btn btn-sage btn-sm" data-bs-toggle="modal"
                    data-bs-target="#unitDetails{{ $unit->id }}">
                    Details
                </button>
            </div>
            <div class="modal fade" id="unitDetails{{ $unit->id }}" tabindex="-1" role="dialog"
                aria-labelledby="unitModaTitleId{{ $unit->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content text-blackbean">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unitModaTitleId{{ $unit->id }}">
                                <span x-text="unitName"></span> Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h3 class="unit-title">{{ $unit->name }}</h3>
                                    <h6 class="card-subtitle text-body-secondary">{{ $unit->view }}</h6>
                                </div>
                                @isset($unit->is_available)
                                    <div class="col align-self-center text-end">
                                        @if ($unit->is_available)
                                            <p class="status text-success fs-5"><i class="bi bi-calendar2-check-fill"></i>
                                                Available </p>
                                        @else
                                            <p class="status text-danger fs-5"><i class="bi bi-calendar2-x-fill"></i>
                                                Not Available
                                            </p>
                                        @endif
                                    </div>
                                @endisset
                            </div>
                            <div class="row g-2 my-3">
                                <div class="col-5 fw-medium ps-2">
                                    <div class=""><x-bedroom-icon /> {{ $unit->bed_config }}</div>
                                    <div class=""><i class="bi bi-people-fill"></i>
                                        {{ $unit->occupancy_limit }} Guest Capacity</div>
                                    @foreach ($unit->amenities as $unit_amenity)
                                        @if ($unit_amenity->amenity->highlight)
                                            <div class="">
                                                @component('components.' . $unit_amenity->icon)
                                                @endcomponent {{ $unit_amenity->name }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-7">
                                    <div id="modalImages{{ $unit->id }}" class="carousel slide">
                                        <div class="carousel-inner rounded-3" role="listbox">
                                            @foreach ($unit->photos as $photo)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset($photo->photos_path) }}"
                                                        class="w-100 d-block img-fluid object-fit-cover rounded-3"
                                                        alt="{{ $unit->name }} Image" style="height: 250px" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#modalImages{{ $unit->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#modalImages{{ $unit->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 fs-4 fw-semibold my-3">Unit Amenities</div>
                                <div class="col-md-6">
                                    <h5><x-bathroom-icon /> Bathroom</h5>
                                    <ul>
                                        @foreach ($unit->amenities as $unit_amenity)
                                            @if ($unit_amenity->category == 'bathroom')
                                                <li class="list-group-item">
                                                    @component('components.' . $unit_amenity->icon)
                                                    @endcomponent {{ $unit_amenity->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5><i class="bi bi-check-lg"></i> Comforts & Entertainment</h5>
                                    <ul>
                                        @foreach ($unit->amenities as $unit_amenity)
                                            @if ($unit_amenity->category == 'comforts')
                                                <li class="list-group-item">
                                                    @component('components.' . $unit_amenity->icon)
                                                    @endcomponent {{ $unit_amenity->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col">
                                    <h5><x-bedroom-icon /> Bedroom</h5>
                                    <ul>
                                        @foreach ($unit->amenities as $unit_amenity)
                                            @if ($unit_amenity->category == 'bedroom')
                                                <li class="list-group-item">
                                                    @component('components.' . $unit_amenity->icon)
                                                    @endcomponent {{ $unit_amenity->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col">
                                    <h5><x-kitchen-icon /> Kitchen</h5>
                                    <ul>
                                        @foreach ($unit->amenities as $unit_amenity)
                                            @if ($unit_amenity->category == 'kitchen')
                                                <li class="list-group-item">
                                                    @component('components.' . $unit_amenity->icon)
                                                    @endcomponent {{ $unit_amenity->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col">
                                    <h5><i class="bi bi-plus-lg"></i> More</h5>
                                    <ul>
                                        @foreach ($unit->amenities as $unit_amenity)
                                            @if ($unit_amenity->category == 'more')
                                                <li class="list-group-item">
                                                    @component('components.' . $unit_amenity->icon)
                                                    @endcomponent {{ $unit_amenity->name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="row justify-content-between border rounded-3 py-2">
                                <div class="col align-self-center text-start">
                                    <p class="fs-5 fw-medium mb-0">Price:<span
                                            class="ms-2">&#8369;{{ number_format($unit->price_per_night) }}</span>
                                    </p>
                                    <p class="fs-6 text-body-secondary mb-0">Per night excluding service charges</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}

    {{-- <form wire:submit="updateBookingForm">
        <div class="row justify-content-center align-items-start g-2 mb-3">
            <div class="col-md-4 col-sm-6">
                <label for="new_checkin" class="form-label small mb-0">New Check-in Date</label>
                <input wire:model="checkin_selected" type="date" class="form-control form-control-sm"
                    id="new_checkin" readonly />
                @error('checkin_selected')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-4 col-sm-6">
                <label for="new_checkout" class="form-label small mb-0">New Check-out Date</label>
                <input wire:model="checkout_selected" type="date" class="form-control form-control-sm"
                    id="new_checkout" readonly />
                @error('checkout_selected')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-4 col-sm-4">
                <label for="new_unit" class="form-label small mb-0">New Unit</label>
                <input wire:model="unit_selected" type="text" class="form-control form-control-sm" id="new_unit"
                    readonly />
                @error('unit_selected')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-blackbean col-lg-9 col-md-6">
                <span class="spinner-border spinner-border-sm text-sage me-1" wire:loading></span>Submit
            </button>
        </div>
    </form> --}}
</div>
