<div class="card rounded-4">
    <div class="card-body">
        {{-- <h4 class="card-title">Title</h4> --}}
        <div class="table-responsive" x-init="window.addEventListener('confirmSuccess', function(e) {
            Swal.fire('Booking Confirmed!', '', 'success');
        });
        window.addEventListener('confirmError', function(e) {
            Swal.fire('Error!', 'Something went wrong in confirming the booking.', 'error');
        });
        window.addEventListener('cancelSuccess', function(e) {
            Swal.fire('Booking Cancelled!', '', 'success');
        });
        window.addEventListener('cancelError', function(e) {
            Swal.fire('Error!', 'Something went wrong in cancelling the booking.', 'error');
        });">
            <table id="manage_bookings" class="table table-secondary">
                <thead>
                    <tr>
                        <th scope="col">Booking ID</th>
                        <th scope="col" class="col-1">Status</th>
                        <th scope="col">Name</th>
                        <th scope="col">Check-in</th>
                        <th scope="col">Check-out</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->reference_no }}</td>
                            <td class="text-center">
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
                            <td>{{ $booking->first_name . ' ' . $booking->last_name }}</td>
                            <td>{{ date('M j, Y', strtotime($booking->checkin_date)) }}</td>
                            <td>{{ date('M j, Y', strtotime($booking->checkout_date)) }}</td>
                            <td>
                                @if ($booking->status == 'pending')
                                    <button type="button" class="btn btn-primary btn-sm w-100 mb-2"
                                        x-data="{
                                            isLoading: false,
                                            alertConfirm() {
                                                Swal.fire({
                                                    title: 'Confirm booking #{{ $booking->reference_no }}?',
                                                    text: '{{ $booking->unit->name }} booked by {{ $booking->first_name . ' ' . $booking->last_name }} from {{ date('M j', strtotime($booking->checkin_date)) }} to {{ date('j, Y', strtotime($booking->checkout_date)) }}.',
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
                                            <span class="spinner-border spinner-border-sm text-light" role="status"
                                                aria-hidden="true"></span>
                                        </template>
                                    </button>
                                    @if (is_null($booking->reason_of_cancel))
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                            x-data="{
                                                isLoading: false,
                                                async alertCancel() {
                                                    this.isLoading = true; // Start the spinner
                                                    const { value: text } = await Swal.fire({
                                                        title: 'Cancel booking #{{ $booking->reference_no }}',
                                                        input: 'textarea',
                                                        inputLabel: 'Customer\'s reason of cancel:',
                                                        inputPlaceholder: 'Type the reason here...',
                                                        inputAttributes: { 'aria-label': 'Type your message here' },
                                                        showCancelButton: true
                                                    });
                                            
                                                    if (text) {
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
                                                <span class="spinner-border spinner-border-sm text-light" role="status"
                                                    aria-hidden="true"></span>
                                            </template>
                                        </button>
                                    @else
                                        <button type ="button" class="btn btn-outline-danger btn-sm w-100"
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
                                                <span class="spinner-border spinner-border-sm text-light" role="status"
                                                    aria-hidden="true"></span>
                                            </template>
                                        </button>
                                    @endif
                                @elseif ($booking->status == 'confirmed')
                                    {{-- <button type="button" class="btn btn-sage btn-sm w-100 mb-2">Notify User</button> --}}
                                    @if (is_null($booking->reason_of_cancel))
                                        <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                            x-data="{
                                                isLoading: false,
                                                async alertCancel() {
                                                    this.isLoading = true; // Start the spinner
                                                    const { value: text } = await Swal.fire({
                                                        title: 'Cancel booking #{{ $booking->reference_no }}',
                                                        input: 'textarea',
                                                        inputLabel: 'Customer\'s reason of cancel:',
                                                        inputPlaceholder: 'Type the reason here...',
                                                        inputAttributes: { 'aria-label': 'Type your message here' },
                                                        showCancelButton: true
                                                    });
                                            
                                                    if (text) {
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
                                                <span class="spinner-border spinner-border-sm text-light" role="status"
                                                    aria-hidden="true"></span>
                                            </template>
                                        </button>
                                    @else
                                        <button type ="button" class="btn btn-outline-danger btn-sm w-100"
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
                                                <span class="spinner-border spinner-border-sm text-light" role="status"
                                                    aria-hidden="true"></span>
                                            </template>
                                        </button>
                                    @endif
                                @elseif ($booking->status == 'checked-in')
                                    
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('scripts')
        <script type="module">
            $('#manage_bookings').DataTable({

            });
        </script>
    @endpush
</div>
