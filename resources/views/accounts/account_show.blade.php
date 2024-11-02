@extends('layouts.manager')
@section('page', 'Accounts')
@section('content')
    <div class="container pt-3 vh-100">
        <div class="row justify-content-center align-items-start g-2">
            <div class="col-12">
                <a href="{{ route('accounts.index') }}" class="text-decoration-none icon-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                  </svg>Go Back</a>
            </div>
            <div class="col-lg-8 col-md-7 order-lg-1 order-md-1 order-sm-2 order-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">User Booking Records</h4>
                        <div class="table-responsive">
                            <table id="user_bookings" class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap text-center">ID</th>
                                        <th scope="col" class="col-1 text-center">Status</th>
                                        <th scope="col" class="text-nowrap text-center">Guest</th>
                                        <th scope="col" class="text-nowrap text-center">Unit</th>
                                        <th scope="col" class="text-nowrap text-center">Check In</th>
                                        <th scope="col" class="text-nowrap text-center">Check Out</th>
                                        <th scope="col" class="text-nowrap text-center"># of Guests</th>
                                        <th scope="col" class="text-nowrap text-center">Nights</th>
                                        <th scope="col" class="text-nowrap text-center">Services Availed</th>
                                        <th scope="col" class="text-nowrap text-center">Down Payment</th>
                                        <th scope="col" class="text-nowrap text-center">Outstanding Balance</th>
                                        <th scope="col" class="text-nowrap text-center">Total Payment</th>
                                        <th scope="col" class="text-nowrap text-center">GCash Reference #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->bookings as $booking)
                                        <tr>
                                            <td class="text-nowrap text-center"><a
                                                    href="{{ route('bookings.show', $booking) }}">#{{ $booking->reference_no }}</a>
                                            </td>
                                            <td class="text-nowrap text-center">
                                                @switch($booking->status)
                                                    @case('pending')
                                                        @if (!is_null($booking->reason_of_cancel))
                                                            <span class="badge text-bg-warning fw-normal text-wrap">Waiting for
                                                                cancellation
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
                                            <td class="text-nowrap">
                                                <p class="mb-0">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                                <p class="mb-0 fst-italic small">{{ $booking->phone_no }}</p>
                                            </td>
                                            <td class="text-nowrap text-center">
                                                {{ $booking->unit->name }}
                                            </td>
                                            <td class="text-nowrap text-center">
                                                {{ date('M j, Y', strtotime($booking->checkin_date)) }}
                                            </td>
                                            <td class="text-nowrap text-center">
                                                {{ date('M j, Y', strtotime($booking->checkout_date)) }}
                                            </td>
                                            <td class="text-nowrap text-center">
                                                <i class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                            </td>
                                            <td class="text-nowrap text-center">
                                                <i
                                                    class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                            </td>
                                            <td class="text-nowrap">
                                                <ul>
                                                    @forelse ($booking->services as $service)
                                                        <li>
                                                            @if ($service->name == 'Meal Service')
                                                                <small data-bs-toggle="tooltip"
                                                                    data-bs-title="{{ $service->service->details }}">
                                                                    Meal Service
                                                                </small>
                                                            @else
                                                                <small>
                                                                    {{ $service->service->quantity . ' ' . $service->name }}
                                                                    (&#8369;{{ number_format($service->service_cost * $service->service->quantity, 2) }})
                                                                </small>
                                                            @endif
                                                        </li>
                                                    @empty
                                                </ul>
                                                <p class="mb-0 text-center fst-italic small text-muted">No services availed
                                                </p>
                                    @endforelse

                                    </td>
                                    <td class="text-nowrap text-center">
                                        &#8369;{{ number_format($booking->total_payment - $booking->outstanding_payment, 2) }}
                                    </td>
                                    <td class="text-nowrap text-center">
                                        &#8369;{{ number_format($booking->outstanding_payment, 2) }}</td>
                                    <td class="text-nowrap text-center">
                                        &#8369;{{ number_format($booking->total_payment, 2) }}</td>
                                    <td class="text-nowrap text-center">
                                        @if (is_null($booking->gcash_ref_no))
                                            <span class="text-muted fst-italic" data-bs-toggle="tooltip"
                                                data-bs-title="This person paid in cash.">Cash Transaction</span>
                                        @else
                                            {{ $booking->gcash_ref_no }}
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @push('scripts')
                                <script type="module">
                                    $(document).ready(function() {
                                        $('#user_bookings').DataTable({
                                            scrollX: true
                                        });
                                    });
                                </script>
                            @endpush
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-5 order-lg-2 order-md-2 order-sm-1 order-1">
                <div class="card text-bg-sage">
                    <div class="card-body">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                                class="bi bi-person-square" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path
                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            </svg>
                        </div>
                        <div class="text-center fs-5 fw-semibold">{{ $account->first_name . ' ' . $account->last_name }}
                        </div>
                        <div class="text-center text-darkgreen mt-n2">{{ ucfirst($account->usertype) }}</div>
                        <div class="text-center">{{ $account->email }}</div>
                        <div class="text-center">{{ $account->phone_no }}</div>
                        <div class="mt-3">Date email verified:
                            {{ $account->email_verified_at ? date('M j, Y', strtotime($account->email_verified_at)) : 'Not yet verified' }}
                        </div>
                        <div class="">Date joined: {{ date('M j, Y', strtotime($account->created_at)) }}</div>
                        <div class="">Date last updated: {{ date('M j, Y', strtotime($account->updated_at)) }}</div>

                        <div class="d-flex flex-column gap-1 mt-4">
                            <a href="{{ route('accounts.edit', $account) }}" class="btn btn-darkgreen w-100">Edit
                                Account</a>
                            @if (!$account->is_archived)
                                <button type="button" class="btn btn-danger w-100" x-data="{
                                    alertConfirm() {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: 'This action cannot be undone.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $('#deactivate').submit();
                                            }
                                        });
                                    }
                                }"
                                    x-on:click="alertConfirm">Deactivate Account</button>
                                <form id="deactivate" action="{{ route('account.deactivate', $account) }}" method="post"
                                    style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            @else
                                <form action="{{ route('account.activate', $account) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-info w-100">Activate Account</button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
