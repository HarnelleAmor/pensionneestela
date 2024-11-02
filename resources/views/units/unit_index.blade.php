@extends('layouts.manager')
@section('page', 'Units')
@section('content')
    <div class="container-fluid py-4 px-5">
        @foreach ($units as $unit)
            <div class="card rounded-4 border-0 shadow mb-5">
                <div class="card-body">
                    <!-- Header Section -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fs-2 fw-medium">{{ $unit->name }}</div>
                        <a href="{{ route('units.edit', $unit) }}" class="btn btn-warning px-4 py-2 rounded-3 shadow">
                            <i class="bi bi-pencil-square me-2"></i>Edit Unit
                        </a>
                    </div>

                    <div class="row align-items-start g-2 mb-3">
                        <!-- Image and Upload Section -->
                        <div class="col-lg-5">
                            <div class="row justify-content-center g-2">
                                <div class="col-12">
                                    @if ($unit->photos->isNotEmpty())
                                        <img src="{{ $unit->photos->first()->photos_path }}"
                                            class="img-fluid rounded-4 h-100 object-fit-cover"
                                            alt="{{ $unit->name }} Image Featured">
                                    @else
                                        <img src="https://via.placeholder.com/500x300" class="img-fluid rounded-4"
                                            alt="{{ $unit->name }} Image Featured">
                                    @endif
                                </div>

                                @foreach ($unit->photos->slice(1, 4) as $photo)
                                    <div class="col-3">
                                        <img src="{{ $photo->photos_path }}"
                                            class="img-fluid rounded-4 h-100 object-fit-cover" alt="Thumbnail">
                                    </div>
                                @endforeach

                                @if ($unit->photos->count() < 5)
                                    @for ($i = 0; $i < 4 - ($unit->photos->count() - 1); $i++)
                                        <div class="col-3">
                                            <img src="https://via.placeholder.com/100x100" class="img-fluid rounded-4"
                                                alt="Thumbnail">
                                        </div>
                                    @endfor
                                @endif

                                <div class="col-12">
                                    <a name="" id=""
                                        class="btn btn-outline-secondary rounded-3 w-100 fw-medium mt-2 shadow"
                                        href="#"role="button">Upload New Photo</a>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Details Section -->
                        <div class="col-lg-7 ps-4">
                            <h2 class="fw-semibold mb-0">&#8369;{{ number_format($unit->price_per_night) }}<span
                                    class="fs-5 text-muted">/night</span></h2>
                            @if ($unit->is_available)
                                <div class="small fw-medium text-success mb-4"><i class="bi bi-door-open me-2"></i>Available
                                </div>
                            @else
                                <div class="small fw-medium text-secondary mb-4"><i
                                        class="bi bi-door-closed me-2"></i>Occupied
                                </div>
                            @endif

                            <div class="row g-3 mb-4">
                                <div class="col-lg-4">
                                    <p class="fw-medium mb-1"><i class="bi bi-people-fill me-1"></i>Capacity</p>
                                    <p class="mb-0">{{ $unit->occupancy_limit }} guests</p>
                                </div>
                                <div class="col-lg-4">
                                    <p class="fw-medium mb-1"><i class="bi bi-house-door-fill me-1"></i>Unit Floor</p>
                                    <p class="mb-0">{{ $unit->location }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <p class="fw-medium mb-1"><x-bedroom-icon /> Bed</p>
                                    <p class="mb-0">{{ $unit->bed_config }}</p>
                                </div>
                                <div class="col-lg-4">
                                    <p class="fw-medium mb-1"><i class="bi bi-card-image me-1"></i>View</p>
                                    <p class="mb-0">{{ $unit->view }}</p>
                                </div>
                            </div>

                            <h5>Unit Amenities</h5>
                            <div class="row g-2 mb-4">
                                @forelse ($unit->amenities as $amenity)
                                    <div class="col-auto border rounded p-2 shadow-sm mx-2">
                                        <p class="fw-medium mb-1">
                                            @component('components.' . $amenity->icon)
                                            @endcomponent {{ $amenity->name }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="col-auto fst-italic text-muted">No amenities</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- Unit Booking History Section -->
                    <div class="">
                        <h5>Unit Booking History<span class="badge text-bg-dark ms-2">{{ $unit->bookings->count() }}</span>
                        </h5>
                        <div class="table-responsive">
                            <table id="unit_bookings{{ $unit->id }}" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Guest's Name</th>
                                        <th class="text-nowrap">Booking Date</th>
                                        <th class="text-nowrap">Check-In</th>
                                        <th class="text-nowrap">Check-Out</th>
                                        <th class="text-nowrap">Guests</th>
                                        <th class="text-nowrap">Night(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unit->bookings as $booking)
                                        <tr>
                                            <td class="text-nowrap">#{{ $booking->reference_no }}</td>
                                            <td class="text-nowrap">{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                            <td class="text-nowrap">{{ date('M j, Y', strtotime($booking->created_at)) }}</td>
                                            <td class="text-nowrap">{{ date('M j, Y', strtotime($booking->checkin_date)) }}</td>
                                            <td class="text-nowrap">{{ date('M j, Y', strtotime($booking->checkout_date)) }}</td>
                                            <td class="text-nowrap">{{ $booking->no_of_guests }} Guest(s)</td>
                                            <td class="text-nowrap text-center">{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @push('scripts')
                                <script type="module">
                                    $('#unit_bookings{{ $unit->id }}').DataTable({
                                        "pageLength": 5,
                                        "scrollY": "300px",
                                        "scrollCollapse": true,
                                        "paging": true,
                                        layout: {
                                            topStart: null,
                                            topEnd: {
                                                search: {
                                                    placeholder: 'Type any keyword here'
                                                }
                                            }
                                        }
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
@endsection
