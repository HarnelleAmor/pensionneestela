<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'E-STELLA') }}</title>
    {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class=""><img src="{{asset('assets/images/background.jpg')}}" alt=""></div>
    <div class="">{{$booking->first_name}} {{$booking->last_name}}</div>
    <div class="">{{$booking->reference_no}}</div>
    <div class="">{{$booking->checkin_date}}</div>
    <div class="">{{$booking->checkout_date}}</div>
    <div class="">{{$booking->unit->name}}</div>
    {{-- <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{$first_name}} {{$last_name}}</h4>
            <p class="card-text">Text</p>
        </div>
    </div> --}}
    
    <div class="row justify-content-center align-items-center g-2 my-3">
        <div class="col-lg-10 card rounded-0 shadow-lg">
            <div class="card-body m-3">
                <div class="row justify-content-between">
                    <div class="col text-start"><x-application-logo width="200" height="80" /></div>
                    <div class="col align-self-end">
                        <div class="text-end fs-3 fw-semibold">Booking Information</div>
                        <div class="text-end text-secondary fs-6"><i
                                class="bi bi-envelope-fill me-2"></i>pensionneestella@gmail.com</div>
                        <div class="text-end text-secondary fs-6"><i class="bi bi-telephone-fill me-2"></i>470-944-7433
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row g-2 mb-3">
                    <div class="col">
                        <div class="fs-5 fw-semibold">Booking Details</div>
                        <table class="w-100">
                            <tr>
                                <th>Booking ID</th>
                                <td class="ps-4"><span
                                        class="badge text-bg-info fs-6 fw-medium">#{{ $booking->reference_no }}</span></td>
                            </tr>
                            <tr>
                                <th>Check-in</th>
                                <td class="ps-4">{{ date('l, F j, Y', strtotime($booking->checkin_date)) }}
                                    {{ $booking->checkin_time != null ? '| ' . date('g:i A', strtotime($booking->checkin_time)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Check-out</th>
                                <td class="ps-4">{{ date('l, F j, Y', strtotime($booking->checkout_date)) }}
                                    {{ $booking->checkout_time != null ? '| ' . date('g:i A', strtotime($booking->checkout_time)) : '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>Guests</th>
                                <td class="ps-4">{{ $booking->no_of_guests }}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td class="ps-4">{{ $booking->unit->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td class="ps-4">
                                    @switch($booking->status)
                                        @case('pending')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal">Waiting for cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-warning fs-6 fw-normal">Pending</span>
                                            @endif
                                        @break

                                        @case('confirmed')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal">Waiting for cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-success fs-6 fw-normal">Confirmed</span>
                                            @endif
                                        @break

                                        @case('checked-in')
                                            <span class="badge text-bg-primary fs-6 fw-normal">Checked-In</span>
                                        @break

                                        @case('checked-out')
                                            <span class="badge text-bg-info fs-6 fw-normal">Checked-Out</span>
                                        @break

                                        @case('no-show')
                                            <span class="badge text-bg-secondary fs-6 fw-normal">No Show</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge text-bg-danger fs-6 fw-normal">Cancelled</span>
                                        @break

                                        @default
                                            <span class="badge text-bg-dark fs-6 fw-normal">...</span>
                                    @endswitch
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row justify-content-between align-items-start g-4 mb-3">
                    <div class="col-md-7">
                        <div class="fs-5 fw-semibold">Booked By</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Name</div>
                                <div class="fw-normal">{{ $booking->first_name }} {{ $booking->last_name }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Email</div>
                                <div class="fw-normal">{{ $booking->email }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Phone Number</div>
                                <div class="fw-normal">{{ $booking->phone_no }}</div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="fw-medium">Booking Date</div>
                                <div class="fw-normal">{{ date('F j, Y g:i A', strtotime($booking->created_at)) }}</div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5">
                        @empty($booking->services)
                            <div class="fs-5 fw-semibold">
                                Services <small class="text-body-secondary">(No services availed)</small>
                            </div>
                        @else
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="fs-5 fw-semibold">Services</div>
                                </div>
                                <div class="card-body">
                                    <ul class="">
                                        @foreach ($booking->services as $service)
                                            <li class="">
                                                @if ($service->name === 'Meal Service')
                                                    <div class="fw-normal">{{ $service->name }}</div>
                                                    <small
                                                        class="text-body-secondary fst-italic">"{{ $service->service->details }}"</small>
                                                @else
                                                    <div class="fw-normal">{{ $service->name }}
                                                        ({{ $service->service->quantity }}x)
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endempty
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fs-5 fw-semibold">
                        Payment Summary
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-between align-items-start g-2">
                            <div class="col-md-7">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="fw-medium">Description</div>
                                        <div class="fw-medium">Amount</div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <small>{{ $no_of_nights }} Night/s
                                            (&#8369;{{ number_format($booking->unit->price_per_night, 2) }})</small>
                                        <div class="fw-normal">
                                            &#8369;{{ number_format($booking->unit->price_per_night * $no_of_nights, 2) }}
                                        </div>
                                    </li>
                                    @foreach ($booking->services as $service)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <small>{{ $service->service->quantity }} {{ $service->name }}
                                                (&#8369;{{ number_format($service->service_cost, 2) }})
                                            </small>
                                            <div class="fw-normal">
                                                &#8369;{{ number_format($service->service_cost * $service->service->quantity, 2) }}
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="list-group-item d-flex justify-content-end align-items-center">
                                        <div class="fw-semibold me-5">Total:</div>
                                        <div class="fw-semibold">&#8369;{{ number_format($booking->total_payment, 2) }}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <div class="alert alert-info" role="alert">
                                    <ul class="list-group list-group-flush mb-3">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="fw-semibold me-5">Down-paid</div>
                                            <div class="fw-semibold">&#8369;{{number_format(($booking->unit->price_per_night * $no_of_nights)/2, 2) }}</div>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="fw-medium">
                                                Outstanding Balance
                                            </div>
                                            <div class="fw-normal">&#8369;{{ number_format($booking->outstanding_payment, 2) }}</div>
                                        </li>
                                    </ul>
                                    <div>GCash Reference #: <span class="fw-medium">{{$booking->gcash_ref_no}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>