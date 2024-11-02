@extends('layouts.manager')
@section('page', 'Dashboard')
@section('content')
    <div class="container py-4 px-4">
        {{-- <div class="row justify-content-between align-items-center mb-2">
            <div class="col-auto align-self-end align-items-center d-lg-flex d-md-flex text-end">
                <a href="{{ route('showUnitCheckPage') }}" class="btn btn-blackbean icon-link rounded-3 py-3 px-4 fw-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                    </svg>Create new booking
                </a>

            </div>
        </div> --}}

        @session('success')
            <div class="alert alert-success alert-dismissible fade show col-lg-6 mx-auto" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    <div class="fw-medium">{{ session('success') }}</div>
                </div>
            </div>
        @endsession
        @session('error')
            <div class="alert alert-danger alert-dismissible fade show col-lg-6 mx-auto" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                    </svg>
                    <div class="fw-medium">{{ session('error') }}</div>
                </div>
            </div>
        @endsession

        <div class="row justify-content-center align-items-center mb-3 g-3">
            <div class="col-lg-3">
                <div class="card card-body bg-sage text-blackbean border-0 rounded-4 shadow d-flex flex-row gap-3 justify-content-start px-4 align-items-center">
                    <div class="rounded-4 p-3 d-flex align-items-end bg-blackbean text-sage-light"
                        style="background-color: var(--bs-secondary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-calendar" viewBox="0 0 16 16">
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="fw-medium mb-0 small">New Booking</p>
                        <p class="mb-0 fs-2 mt-n2">{{ $pending_bookings->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-body bg-blackbean text-sage-light border-0 rounded-4 shadow d-flex flex-row gap-3 justify-content-start px-4 align-items-center">
                    <div class="rounded-4 p-3 d-flex align-items-end bg-sage-light text-darkgreen"
                        style="background-color: var(--bs-secondary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-people-fill me-1" viewBox="0 0 16 16">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                    <div>
                        <p class="fw-medium mb-0 small">Customers</p>
                        <p class="mb-0 fs-2 mt-n2">{{ $total_customers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div
                    class="card card-body bg-darkgreen text-sage-light border-0 rounded-4 shadow d-flex flex-row gap-3 justify-content-start px-4 align-items-center">
                    <div class="rounded-4 p-3 d-flex align-items-end bg-sage-light text-darkgreen"
                        style="background-color: var(--bs-secondary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-cash-coin" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0" />
                            <path
                                d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z" />
                            <path
                                d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z" />
                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567" />
                        </svg>
                    </div>
                    <div>
                        <p class="fw-medium mb-0 small">Total Revenue</p>
                        <p class="mb-0 fs-2 mt-n2">&#8369;{{ number_format($total_revenue, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-body bg-mossgreen text-darkgreen border-0 rounded-4 shadow d-flex flex-row gap-3 justify-content-start px-4 align-items-center">
                    <div class="rounded-4 p-3 d-flex align-items-end bg-darkgreen text-sage-light"
                        style="background-color: var(--bs-secondary-bg);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-people-fill me-1" viewBox="0 0 16 16">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                    <div>
                        <p class="fw-medium mb-0 small">Customers</p>
                        <p class="mb-0 fs-2 mt-n2">{{ $total_customers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-evenly align-items-start mb-3 g-3">
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="fs-5 fw-semibold">Bookings</div>
                            {{-- <div>
                                <select
                                    class="form-select form-select-sm d-inline-flex"
                                    name=""
                                    id=""
                                >
                                    <option selected>All</option>
                                    <option value="">This Week</option>
                                    <option value="">Last</option>
                                    <option value="">Jakarta</option>
                                </select>
                            </div> --}}
                        </div>
                        <canvas id="bookings"></canvas>
                        @push('scripts')
                            <script type="module">
                                const ctx = document.getElementById('bookings');
                                const donutTotal = {
                                    id: 'donutTotal',
                                    beforeDatasetsDraw(chart, args, pluginOptions) {
                                        const { ctx, data } = chart;
                                        ctx.save();
                                        const xCoor = chart.getDatasetMeta(0).data[0].x;
                                        const yCoor = chart.getDatasetMeta(0).data[0].y;
                                        ctx.font = 'bold 2rem Figtree';
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'middle';
                                        ctx.fillText('{{ $donut_bookings["total"] }}', xCoor, yCoor);
                                    }
                                };
                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: @json($donut_bookings['labels']),
                                        datasets: [{
                                            label: 'Number of Bookings',
                                            data: @json($donut_bookings['data']),
                                            backgroundColor: [
                                                'rgb(255, 209, 102)',
                                                'rgb(6, 214, 160)',
                                                'rgb(17, 138, 178)',
                                                'rgb(239, 71, 111)',
                                                'rgb(108, 117, 125)'
                                            ],
                                            hoverOffset: 4
                                        }]
                                    },
                                    options: {
                                        plugins: {
                                            legend: {
                                                position: 'bottom'
                                            }
                                        }
                                    },
                                    plugins: [donutTotal]
                                });
                            </script>
                        @endpush
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 shadow">
                    <div class="card-body">
                        @foreach ($units as $unit)
                            @if ($unit->is_available)
                                <div class="alert alert-warning d-flex align-items-center border-0 rounded-4" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-door-open flex-shrink-0 ms-2 me-3" viewBox="0 0 16 16">
                                        <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                                        <path
                                            d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                                    </svg>
                                    <p class="mb-0 fw-medium">{{ $unit->name }} is <strong>vacant</strong> today.</p>
                                </div>
                            @else
                                <div class="alert alert-primary d-flex align-items-center border-0 rounded-4"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-door-closed flex-shrink-0 ms-2 me-3" viewBox="0 0 16 16">
                                        <path
                                            d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z" />
                                        <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0" />
                                    </svg>
                                    <p class="mb-0 fw-medium">{{ $unit->name }} is <strong>occupied</strong> today.</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 shadow">
                    <div class="card-body">
                        @foreach ($units as $unit)
                            @if ($unit->is_available)
                                <div class="alert alert-warning d-flex align-items-center border-0 rounded-4" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-door-open flex-shrink-0 ms-2 me-3" viewBox="0 0 16 16">
                                        <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                                        <path
                                            d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                                    </svg>
                                    <p class="mb-0 fw-medium">{{ $unit->name }} is <strong>vacant</strong> today.</p>
                                </div>
                            @else
                                <div class="alert alert-primary d-flex align-items-center border-0 rounded-4"
                                    role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-door-closed flex-shrink-0 ms-2 me-3" viewBox="0 0 16 16">
                                        <path
                                            d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z" />
                                        <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0" />
                                    </svg>
                                    <p class="mb-0 fw-medium">{{ $unit->name }} is <strong>occupied</strong> today.</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-start mb-3 g-3">
            <div class="col-lg-12">
                <div class="card border-0 rounded-4 shadow" style="height: 30rem">
                    <div class="card-header rounded-top-4 d-flex justify-content-between align-items-center">
                        <div class="fs-4 fw-semibold">Guest Bookings<span
                                class="badge text-bg-secondary ms-2">{{ $pending_bookings->count() + $upcoming_bookings->count() + $checkin_bookings->count() + $checkout_bookings->count() }}</span>
                        </div>
                        <a href="{{ route('bookings.index') }}" class="text-decoration-none">
                            View all
                        </a>
                    </div>
                    <div class="card-body pt-0 px-0 overflow-y-auto">
                        <ul class="nav nav-underline nav-justified sticky-top text-bg-light z-2" id="guestOverview" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pending-booking" data-bs-toggle="tab"
                                    data-bs-target="#pending-booking-pane" type="button" role="tab"
                                    aria-controls="pending-booking-pane" aria-selected="true">Pending<span
                                        class="badge text-bg-warning ms-2">{{ $pending_bookings->count() }}</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="upcoming-booking" data-bs-toggle="tab"
                                    data-bs-target="#upcoming-booking-pane" type="button" role="tab"
                                    aria-controls="upcoming-booking-pane" aria-selected="false">Upcoming<span
                                        class="badge text-bg-success ms-2">{{ $upcoming_bookings->count() }}</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="checkin-booking" data-bs-toggle="tab"
                                    data-bs-target="#checkin-booking-pane" type="button" role="tab"
                                    aria-controls="checkin-booking-pane" aria-selected="false">Check-In<span
                                        class="badge text-bg-primary ms-2">{{ $checkin_bookings->count() }}</span></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="checkout-booking" data-bs-toggle="tab"
                                    data-bs-target="#checkout-booking-pane" type="button" role="tab"
                                    aria-controls="checkout-booking-pane" aria-selected="false">Check-Out<span
                                        class="badge text-bg-info ms-2">{{ $checkout_bookings->count() }}</span></button>
                            </li>
                        </ul>
                        <div class="tab-content mt-1" id="guestOverviewContent">
                            <div class="tab-pane fade show active" id="pending-booking-pane" role="tabpanel" aria-labelledby="pending-booking" tabindex="0">
                                <ul class="list-group">
                                    @forelse ($pending_bookings as $booking)
                                        <a href="{{ route('bookings.show', $booking) }}" class="list-group-item align-items-center list-group-item-action shadow-sm">
                                            <div class="row justify-content-lg-between align-items-center">
                                                <div class="col-md-5 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->first_name }}
                                                        {{ $booking->last_name }}</div>
                                                    <div>Ref. No.:
                                                        {{ $booking->gcash_ref_no ? $booking->gcash_ref_no : 'Cash Transaction' }}
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->unit->name }} | <i
                                                            class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                                        | <i
                                                            class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                                    </div>
                                                    {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                                </div>
                                                <div class="col-lg-3 col-md-3 text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <form action="{{ route('booking.confirm', $booking->id) }}" method="post">
                                                            @method('PATCH')
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success text-center">Confirm</button>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <li class="list-group-item align-items-center text-bg-secondary text-center fs-5">
                                            There are no pending bookings
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="upcoming-booking-pane" role="tabpanel"
                                aria-labelledby="upcoming-booking" tabindex="0">
                                <ul class="list-group">
                                    @forelse ($upcoming_bookings as $booking)
                                        <a href="{{ route('bookings.show', $booking) }}"
                                            class="list-group-item align-items-center list-group-item-action shadow-sm">
                                            <div class="row justify-content-lg-between align-items-center">
                                                <div class="col-md-5 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->first_name }}
                                                        {{ $booking->last_name }}</div>
                                                    <div>Ref. No.: <span
                                                            class="text-decoration-underline">{{ $booking->gcash_ref_no }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->unit->name }} | <i
                                                            class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                                        | <i
                                                            class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                                    </div>
                                                    {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                                </div>
                                                <div class="col-lg-3 col-md-3 text-end">
                                                    <form action="{{ route('bookings.show', $booking->id) }}"
                                                        method="get">
                                                        <button type="submit" class="btn btn-success text-center"
                                                            onclick="event.preventDefault();window.location.href='{{ route('bookings.show', $booking->id) }}'">View</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <li class="list-group-item align-items-center text-bg-secondary text-center fs-5">
                                            There are no upcoming bookings
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="checkin-booking-pane" role="tabpanel"
                                aria-labelledby="checkin-booking" tabindex="0">
                                <ul class="list-group">
                                    @forelse ($checkin_bookings as $booking)
                                        <a href="{{ route('bookings.show', $booking) }}"
                                            class="list-group-item align-items-center list-group-item-action shadow-sm">
                                            <div class="row justify-content-lg-between align-items-center">
                                                <div class="col-md-5 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->first_name }}
                                                        {{ $booking->last_name }}</div>
                                                    <div>Ref. No.: <span
                                                            class="text-decoration-underline">{{ $booking->gcash_ref_no }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->unit->name }} | <i
                                                            class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                                        | <i
                                                            class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                                    </div>
                                                    {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                                </div>
                                                <div class="col-lg-3 col-md-3 text-end">
                                                    <form action="{{ route('booking.checkin', $booking->id) }}"
                                                        method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-primary text-center">Check-In</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <li class="list-group-item align-items-center text-bg-secondary text-center fs-5">
                                            We have no expecting guests today.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="checkout-booking-pane" role="tabpanel"
                                aria-labelledby="checkout-booking" tabindex="0">
                                <ul class="list-group">
                                    @forelse ($checkout_bookings as $booking)
                                        <a href="{{ route('bookings.show', $booking) }}"
                                            class="list-group-item align-items-center list-group-item-action shadow-sm">
                                            <div class="row justify-content-lg-between align-items-center">
                                                <div class="col-md-5 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->first_name }}
                                                        {{ $booking->last_name }}</div>
                                                    <div>Ref. No.: <span
                                                            class="text-decoration-underline">{{ $booking->gcash_ref_no }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="fw-medium">{{ $booking->unit->name }} | <i
                                                            class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                                        | <i
                                                            class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                                    </div>
                                                    {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                                </div>
                                                <div class="col-lg-3 col-md-3 text-end">
                                                    <form action="{{ route('booking.checkout', $booking->id) }}"
                                                        method="post">
                                                        @method('PATCH')
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-info text-center">Check-Out</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <li class="list-group-item align-items-center text-bg-secondary text-center fs-5">
                                            We have no expecting guests today.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card rounded-4 shadow" style="height: 30rem">
                    <div class="card-header fs-5 fw-semibold">
                        Cancellation Requests<span class="badge text-bg-danger ms-2">{{ $for_approvals->count() }}</span>
                    </div>
                    <div class="card-body pt-1 overflow-y-auto">
                        <ul class="list-group" style="height: 22rem;">
                            @forelse ($for_approvals as $booking)
                                <a href="{{ route('bookings.show', $booking) }}"
                                    class="list-group-item align-items-center list-group-item-action shadow-sm">
                                    <div class="row justify-content-lg-between align-items-center g-2">
                                        <div class="col-12">
                                            <div class="fw-medium">{{ $booking->first_name }} {{ $booking->last_name }} |
                                                <span class="fst-italic">{{ $booking->unit->name }}</span>
                                            </div>
                                            <div>
                                                <small>{{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="fst-italic text-truncate">"{{ $booking->reason_of_cancel }}"</div>
                                        </div>
                                        <div class="col-12 text-end">
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="post">
                                                @method('PATCH')
                                                @csrf
                                                <button type="submit" class="btn btn-danger text-center">Confirm
                                                    Cancellation</button>
                                            </form>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <li class="list-group-item align-items-center text-bg-secondary text-center fs-5">
                                    No Data
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
@endsection
