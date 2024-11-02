<div class="modal fade" id="unitModal{{ $unit->id }}" tabindex="-1" aria-labelledby="unitModalLabel{{ $unit->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unitModalLabel{{ $unit->id }}">Unit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- unit detail contents -->
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
                                    Not
                                    Available
                                </p>
                            @endif
                        </div>
                    @endisset
                </div>
                <div class="d-flex flex-wrap gap-2 my-3 fw-medium">
                    <div class="border border-primary-subtle p-2 rounded"><x-bedroom-icon /> {{ $unit->bed_config }}
                    </div>
                    <div class="border border-primary-subtle p-2 rounded"><i class="bi bi-people-fill"></i>
                        {{ $unit->occupancy_limit }} Guest Capacity</div>
                    @foreach ($unit->amenities as $unit_amenity)
                        @if ($unit_amenity->amenity->highlight)
                            <div class="border border-primary-subtle p-2 rounded">
                                @component('components.' . $unit_amenity->icon)
                                @endcomponent {{ $unit_amenity->name }}
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Unit Amenities --}}
                <div class="row mb-2">
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
                    <div class="col align-self-end text-end">
                        @if ($unit->is_available)
                            <button type="button" class="btn btn-blackbean rounded-3 shadow-sm fw-medium"
                                data-bs-toggle="modal" data-bs-target="#bookingModalComp{{$unit->id}}">Book this Unit</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bookingModalComp{{$unit->id}}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="bookingModalComp{{$unit->id}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" x-data="{ advisoryCheck: true }">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalComp{{$unit->id}}Label">
                    Booking Advisory
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li class="fs-6 fw-medium lh-sm">To book a transient unit,
                            you have to secure a downpayment through
                            <strong>GCash</strong> with the indicated amount later
                            on in the booking form.
                        </li>
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
                    <input class="form-check-input" type="checkbox" id="policyAgreementComp{{$unit->id}}"
                        x-on:click="advisoryCheck = !advisoryCheck" />
                    <label class="form-check-label" for="policyAgreementComp{{$unit->id}}"> I have
                        read and understand the advisory.</label>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('unit.selected') }}" method="post" class="mb-0">
                    @csrf
                    <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                    <input type="hidden" name="checkin" value="{{ $unit->checkin_date }}">
                    <input type="hidden" name="checkout" value="{{ $unit->checkout_date }}">
                    <button type="submit" class="btn btn-blackbean rounded-3 shadow"
                        x-bind:disabled="advisoryCheck">Book Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
