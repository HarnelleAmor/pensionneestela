@extends('layouts.guest')

@section('content')
    <!-- Header -->
    <section id="home" class="banner_main position-relative">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true">
            <!-- Indicators -->
            {{-- Comment: I think dito galing ung mga nagpapakita na '1. 2. 3.' sa carousel --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
            </div>

            
            <!-- Carousel items -->
            <div class="carousel-inner">
                <div class="carousel-item active carouselitem-bannerhome" data-bs-interval="4000">
                    <img src="{{ asset('assets/images/banner1.jpg') }}" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item carouselitem-bannerhome" data-bs-interval="4000">
                    <img src="{{ asset('assets/images/banner2.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item carouselitem-bannerhome" data-bs-interval="4000">
                    <img src="{{ asset('assets/images/banner3.jpg') }}" class="d-block w-100" alt="Banner 3">
                </div>
            </div>

            <!-- Carousel controls -->
            <button class="carousel-control-prev" data-bs-target="#carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" data-bs-target="#carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
        <!-- End Carousel -->

        <!-- Check Availability Overlay -->
        <div class="check-availability d-flex justify-content-center">
            <form method="GET" action="{{ route('unit.search') }}">
                <div class="d-flex flex-wrap align-items-end">
                    <div class="mb-3 me-2">
                        <label for="checkin" class="form-label">Check-in</label>
                        <input type="date" class="form-control" id="checkin" name="check-in"
                            value="{{ old('check-in') }}" placeholder="Start date" required />
                        @error('check-in')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 me-2">
                        <label for="checkout" class="form-label">Check-out</label>
                        <input type="date" class="form-control" id="checkout" name="check-out"
                            value="{{ old('check-out') }}" placeholder="End date" required />
                        @error('check-out')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-blackbean px-4 icon-link icon-link-hover">
                            Search Units
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- End Check Availability Overlay -->
    </section>

    <!-- Unit Details Section -->
    <div id="units" class="container my-5 unit-details-section">
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
                                    <div class="col-md-5 order-2 order-sm-1">
                                        <h3>{{ $unit->name }}</h3>
                                        <p class="mb-0"><i class="bi bi-people-fill"></i> {{ $unit->occupancy_limit }} Guest Capacity</p>
                                        <p class="mb-0"><x-bedroom-icon /> {{ $unit->bed_config }}</p>
                                    </div>
                                    <div class="col-md-7 order-1 order-sm-2">
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
                                    <div class="col-12 order-3">
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
                                    <div class="col-12 order-4 text-center">
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
                                        {{-- @isset($unit->is_available)
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
                                        @endisset --}}
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
                                        <div class="col align-self-end text-end">
                                            {{-- Cases: not auth user, auth user --}}
                                            @auth
                                                <a href="{{ route('showUnitCheckPage') }}" class="btn btn-blackbean px-4">Check
                                                    Availability</a>
                                            @else
                                                <button type="button" class="btn btn-blackbean px-4" data-bs-dismiss="modal"
                                                aria-label="Close"
                                                x-data
                                                x-on:click="
                                                    setTimeout(() => {
                                                        window.location.href = '#home'
                                                    }, 300);
                                                "
                                                >Check Availability</button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>

    <div id="gallery" class="container position-relative my-5">
        <div class="row justify-content-center">
            <!-- Main Content Area for Gallery -->
            <main class="col-md-10">
                <h2 class="text-center text-uppercase mb-5">Gallery</h2>
    
                <!-- Gallery Section -->
                <div class="d-flex gap-3 overflow-auto" style="white-space: nowrap;">
                    @foreach ($photos as $photo)
                        <div class="rounded-3 flex-shrink-0" style="height: 50vh; width: 70vh;">
                            <img src="{{ asset($photo->photos_path) }}" alt="{{ $photo->descr }}" class="img-fluid object-fit-cover h-100 w-100">
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    

    <div id="aboutus" class="container my-5">
        <!-- About Us Section -->
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-uppercase font-weight-bold mb-4 mt-5">About Us</h1>
                <p class="lead">
                    Welcome to Pensionne Estela! Since <strong>2002</strong>, we have offered personalized services, ensuring our guests enjoy comfort and convenience during their stay.
                </p>
            </div>
        </div>
    
        <!-- Why Choose Us Section -->
        <div class="row mt-5 text-center">
            <div class="col-md-12">
                <h2 class="text-uppercase font-weight-bold mb-4">Why Choose Us?</h2>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light shadow-sm py-4">
                    <i class="bi bi-house-door-fill h1 text-primary mb-3"></i>
                    <h5 class="text-uppercase">Comfortable Rooms</h5>
                    <p>Modern and well-equipped designed for your comfort.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light shadow-sm py-4">
                    <i class="bi bi-people-fill h1 text-primary mb-3"></i>
                    <h5 class="text-uppercase">Friendly Staff</h5>
                    <p>Our attentive and welcoming staff, always here to assist you.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light shadow-sm py-3">
                    <i class="bi bi-geo-alt-fill h1 text-primary mb-3"></i>
                    <h5 class="text-uppercase">Convenient Location</h5>
                    <p>Located close to major attractions, ensuring easy access and transportation.</p>
                </div>
            </div>
        </div>
    
        <!-- Location Section -->
        <div class="row mt-5 text-center">
            <div class="col-md-12">
                <h2 class="text-uppercase font-weight-bold mb-4">Location</h2>
            </div>
            <div class="col-md-12">
                <div class="map-responsive mx-auto" style="max-width: 600px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.121928515258!2d120.57459767388212!3d16.41863282999196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a1acca18388b%3A0xd58215a005243235!2sPensionne%20Estela!5e0!3m2!1sen!2sph!4v1714650722413!5m2!1sen!2sph"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Ensure check-in date is not in the past
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');

        // Set minimum date for check-in (today's date)
        checkinInput.setAttribute('min', today);
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const formattedTomorrow = tomorrow.toISOString().split('T')[0];
        // Set minimum date for check-out (tomorrow's date)
        checkoutInput.setAttribute('min', formattedTomorrow);

        // Add event listener to check-in date input
        checkinInput.addEventListener('change', function () {
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
    @endpush
    
@endsection