@extends('layouts.guest')

@section('content')
    <!-- Unit Details Section -->
    <div class="unit-details-section py-5">
        <div class="container mt-5 pt-5">
            <!-- Title and Intro -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="titlepage text-center">
                        <h2>UNITS</h2>
                        <p>Select a unit below to view details and book.</p>
                    </div>
                </div>
            </div>

            {{-- Display Selected Dates --}}
            @if (isset($show_in))
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="alert alert-info text-center">
                            <strong>Selected Dates:</strong> {{ $show_in }} - {{ $show_out }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Units Selection -->
            <div class="row justify-content-center g-4">
                @foreach ($units as $unit)
                    <div class="col-md-6">
                        <div class="card bg-sage-light px-3 border-0 rounded-4 shadow-sm">
                            <div class="card-body">
                                <div class="row justify-content-center g-2">
                                    <div class="col-md-5">
                                        <h3>{{ $unit->name }}</h3>
                                        @isset($unit->is_available)
                                            @if ($unit->is_available)
                                                <p class="status text-success"><i class="bi bi-calendar2-check-fill"></i>
                                                    Available </p>
                                            @else
                                                <p class="status text-danger"><i class="bi bi-calendar2-x-fill"></i> Not
                                                    Available
                                                </p>
                                            @endif
                                        @endisset
                                        <p class="mb-0"><i class="bi bi-people-fill"></i> {{ $unit->occupancy_limit }} Guest Capacity</p>
                                        <p class="mb-0"><x-bedroom-icon /> {{ $unit->bed_config }}</p>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="unitImagesCarousel{{ $unit->id }}" class="carousel slide">
                                            <div class="carousel-inner rounded-3" role="listbox">
                                                @foreach ($unit->photos as $photo)
                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                        <img src="{{ asset($photo->photos_path) }}"
                                                            class="w-100 d-block img-fluid object-fit-cover rounded-3"
                                                            alt="{{ $unit->name }} Image" style="height: 150px" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#unitImagesCarousel{{ $unit->id }}"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#unitImagesCarousel{{ $unit->id }}"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="gap-2">
                                            @foreach ($unit->amenities as $unit_amenity)
                                                @if ($unit_amenity->amenity->highlight)
                                                    <div class="d-inline-flex border border-dark-subtle rounded-3 p-2 align-items-center mb-2 small">
                                                        @component('components.' . $unit_amenity->icon)
                                                        @endcomponent <span class="ms-1">{{ $unit_amenity->name }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-darkgreen w-75 text-center" data-bs-toggle="modal"
                                            data-bs-target="#unitModal{{ $unit->id }}">See More <i
                                                class="bi bi-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Details Modal -->
                    <div class="modal fade" id="unitModal{{ $unit->id }}" tabindex="-1"
                        aria-labelledby="unitModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-fullscreen-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="unitModalLabel">Unit Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                                                    <p class="status text-success fs-5"><i
                                                            class="bi bi-calendar2-check-fill"></i>
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
                                                    data-bs-target="#modalImages{{ $unit->id }}"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#modalImages{{ $unit->id }}"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Unit Amenities --}}
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
                                        <div class="col align-self-end text-end" 
                                            x-data="{
                                                loginAlert() {
                                                    Swal.fire({
                                                        icon: 'info',
                                                        text: 'Please log-in to book this unit.',
                                                        confirmButtonText: 'Login'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = '{{route('login')}}';
                                                        }
                                                    });
                                                }
                                            }"
                                        >
                                            @isset($show_in, $show_out)
                                                <button type="button" class="btn btn-blackbean px-4" x-on:click="loginAlert">Book</button>
                                            @else
                                                {{-- Cases: not auth user, auth user --}}
                                                @auth
                                                    <a href="{{ route('showUnitCheckPage') }}" class="btn btn-blackbean px-4">Check
                                                        Availability</a>
                                                @else
                                                    <button type="button" class="btn btn-blackbean px-4" x-on:click="loginAlert">Book</button>
                                                @endauth
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    {{-- 
        Amenity Categories:
            - Bedroom (1 Closet)
            - Bathroom (Bidet, Shower, Free Toilet Paper)
            - Kitchen Amenities (1 Refrigerator, 1 Microwave, 1 Electric Kettle, 1 Double Burner, 1 Rice Cooker)
            - Entertainment and Comforts (Free Wifi, Smart TV, Dining Table, Couch, Fan, Sockets near bed)
            - More (Meal Service, Free parking space, Segregated Trash Bins)
        Upon request:
            - Towels
            - Extra Pillows
            - Extra Blankets
            - Extra Foam Mattress
            - Meal Service
    --}}
@endsection
