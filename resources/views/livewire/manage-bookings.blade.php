<div>
    <div class="row justify-content-center align-items-start g-2 mb-2">
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-light text-blackbean">
                    <h4 class="card-title mb-0">Check-In Bookings</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group small">
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
                                        <form action="{{ route('booking.checkin', $booking->id) }}" method="post">
                                            @method('PATCH')
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-primary btn-sm text-center">Check-In</button>
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
        <div class="col">
            <div class="card">
                <div class="card-header text-bg-light text-blackbean">
                    <h4 class="card-title mb-0">Check-Out Bookings</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group small">
                        @forelse ($checkout_bookings as $booking)
                            <li class="list-group-item align-items-center list-group-item-action shadow-sm">
                                <div class="row justify-content-lg-between align-items-center">
                                    <div class="col-md-5 col-sm-6">
                                        <div class="fw-medium">{{ $booking->first_name }}
                                            {{ $booking->last_name }}</div>
                                        <div>Ref. No.: <span
                                                class="text-decoration-underline">{{ $booking->gcash_ref_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <a href="{{ route('bookings.show', $booking) }}" class="text-decoration-none text-reset">
                                            <div class="fw-medium">{{ $booking->unit->name }} | <i
                                                class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                                            | <i
                                                class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                                        </div>
                                        {{ date('F j', strtotime($booking->checkin_date)) }}-{{ date('j, Y', strtotime($booking->checkout_date)) }}
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-3 text-end">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#checkOutConfirmModal{{ $booking->id }}">
                                            Check-Out
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <div class="modal fade" id="checkOutConfirmModal{{ $booking->id }}" tabindex="-1"
                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                aria-labelledby="checkoutModalTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title" id="checkoutModalTitleId">
                                                Check-Out Confirmation
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('booking.checkout', $booking->id) }}"
                                            method="post">
                                            @method('PATCH')
                                            @csrf
                                            <div class="modal-body">
                                                <div class="fw-medium">Any damages done to the Unit? <span
                                                        class="fst-italic text-secondary fw-normal">Leave this
                                                        as is if none</span></div>
                                                <div class="hstack gap-3">
                                                    <label for="damage_fee" class="form-label mb-0 text-nowrap">Damage Fee:</label>
                                                    <input class="form-control form-control-sm" type="number"
                                                        name="damage_fee" id="damage_fee" placeholder="Place the amount here..." min="0" value="0" required>
                                                </div>
                                                @error('damage_fee')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                    <button type="submit" class="btn btn-blackbean text-center">Check-Out</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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

    <div class="card mb-3">
        <div class="card-header text-bg-blackbean">
            <h4 class="card-title mb-0">Manage Bookings</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive" x-init="window.addEventListener('confirmSuccess', function(e) {
                Swal.fire('Booking Confirmed!', '', 'success');
                $wire.bookingRefresh();
            });
            window.addEventListener('confirmError', function(e) {
                Swal.fire('Error!', 'Something went wrong in confirming the booking.', 'error');
                $wire.bookingRefresh();
            });
            window.addEventListener('cancelSuccess', function(e) {
                Swal.fire('Booking Cancelled!', '', 'success');
                $wire.bookingRefresh();
            });
            window.addEventListener('cancelError', function(e) {
                Swal.fire('Error!', 'Something went wrong in cancelling the booking.', 'error');
                $wire.bookingRefresh();
            });">
                <table id="manage_bookings" class="table small">
                    <thead>
                        <tr>
                            <th scope="col">Booking ID</th>
                            <th scope="col">Status</th>
                            <th scope="col">Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Check-in</th>
                            <th scope="col">Check-out</th>
                            <th scope="col">GCash Ref. No.</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr wire:key="{{ $booking->id }}">
                                <td>{{ $booking->reference_no }}</td>
                                <td class="text-center">
                                    @switch($booking->status)
                                        @case('pending')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal text-wrap">Waiting for
                                                    cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-warning fw-normal">Pending</span>
                                            @endif
                                        @break

                                        @case('confirmed')
                                            @if (!is_null($booking->reason_of_cancel))
                                                <span class="badge text-bg-warning fw-normal">Waiting for cancellation
                                                    approval</span>
                                            @else
                                                <span class="badge text-bg-success fw-normal">Confirmed</span>
                                            @endif
                                        @break

                                        @case('checked-in')
                                            <span class="badge text-bg-primary fw-normal">Checked-In</span>
                                        @break

                                        @case('checked-out')
                                            <span class="badge text-bg-info fw-normal">Checked-Out</span>
                                        @break

                                        @case('no-show')
                                            <span class="badge text-bg-secondary fw-normal">No Show</span>
                                        @break

                                        @case('cancelled')
                                            <span class="badge text-bg-danger fw-normal">Cancelled</span>
                                        @break

                                        @default
                                            <span class="badge text-bg-dark fw-normal">...</span>
                                    @endswitch
                                </td>
                                <td>{{ $booking->first_name . ' ' . $booking->last_name }}</td>
                                <td>{{ $booking->unit->name }}</td>
                                <td>{{ date('M j, Y', strtotime($booking->checkin_date)) }}</td>
                                <td>{{ date('M j, Y', strtotime($booking->checkout_date)) }}</td>
                                <td>{{ $booking->gcash_ref_no ? $booking->gcash_ref_no : 'Cash Transaction' }}</td>
                                <td>
                                    <div class="d-flex flex-row gap-2">
                                        @if (($booking->status == 'pending' || $booking->status == 'confirmed') && is_null($booking->reason_of_cancel))
                                            @if ($booking->status == 'pending')
                                                <button type="button" class="btn btn-blackbean btn-sm"
                                                    x-data="{
                                                        isLoading: false,
                                                        alertConfirm() {
                                                            Swal.fire({
                                                                title: 'Confirm booking #{{ $booking->reference_no }}?',
                                                                text: '{{ $booking->first_name . ' ' . $booking->last_name }} wants to book {{ $booking->unit->name }} from {{ date('M j', strtotime($booking->checkin_date)) }} to {{ date('j, Y', strtotime($booking->checkout_date)) }}.',
                                                                icon: 'question',
                                                                confirmButtonText: 'Yes',
                                                                confirmButtonColor: '#3085d6',
                                                                showCancelButton: true
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    this.isLoading = true; // Start spinner
                                                                    $wire.confirm({{ $booking->id }}).then(() => {
                                                                        this.isLoading = false; // Stop spinner after completion
                                                                    });
                                                                }
                                                            });
                                                        },
                                                    }" x-on:click="alertConfirm">

                                                    <template x-if="!isLoading">
                                                        <span>Confirm</span>
                                                    </template>
                                                    <template x-if="isLoading">
                                                        <span class="spinner-border spinner-border-sm text-light"
                                                            role="status" aria-hidden="true"></span>
                                                    </template>
                                                </button>
                                            @endif
                                        @endif
                                        @if (is_null($booking->reason_of_cancel))
                                            <a href="{{ route('rebooking.formCreate', $booking) }}"
                                                class="btn btn-outline-darkgreen btn-sm">Reschedule</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                x-data="{
                                                    isLoading: false,
                                                    async alertCancel() {
                                                        const { value: text } = await Swal.fire({
                                                            title: 'Cancel booking #{{ $booking->reference_no }}',
                                                            input: 'textarea',
                                                            inputLabel: 'Reason:',
                                                            inputPlaceholder: 'Type the reason here...',
                                                            inputAttributes: { 'aria-label': 'Type your message here' },
                                                            showCancelButton: true,
                                                        });
                                                
                                                        if (text) {
                                                            this.isLoading = true; // Start the spinner
                                                            $wire.cancel({{ $booking->id }}, text).then(() => {
                                                                this.isLoading = false; // Stop the spinner after sending
                                                            });
                                                        } else {
                                                            this.isLoading = false; // Stop the spinner if cancelled
                                                        }
                                                    },
                                                }" x-on:click="alertCancel">

                                                <template x-if="!isLoading">
                                                    <span>Cancel</span>
                                                </template>
                                                <template x-if="isLoading">
                                                    <span class="spinner-border spinner-border-sm text-danger"
                                                        role="status" aria-hidden="true"></span>
                                                </template>
                                            </button>
                                        @else
                                            <button type ="button" class="btn btn-outline-danger btn-sm"
                                                x-data="{
                                                    isLoading: false,
                                                    alertConfirmCancel() {
                                                        Swal.fire({
                                                            icon: 'question',
                                                            title: 'Confirm Cancellation?',
                                                            text: 'Customer\'s reason: {{ $booking->reason_of_cancel }}',
                                                            showCancelButton: true
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                this.isLoading = true; // Start spinner
                                                                $wire.cancel({{ $booking->id }}, '{{ $booking->reason_of_cancel }}').then(() => {
                                                                    this.isLoading = false; // Stop spinner after completion
                                                                });
                                                            }
                                                        });
                                                    }
                                                }" x-on:click="alertConfirmCancel">
                                                <template x-if="!isLoading">
                                                    <span>Confirm Cancel</span>
                                                </template>
                                                <template x-if="isLoading">
                                                    <span class="spinner-border spinner-border-sm text-danger"
                                                        role="status" aria-hidden="true"></span>
                                                </template>
                                            </button>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            $('#manage_bookings').DataTable({
                columnDefs: [{
                    targets: -1, // Last column
                    searchable: false,
                    orderable: false
                }]
            });
        </script>
    @endpush
</div>
