<div class="card rounded-4"
    x-init="

    "
>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Ongoing Unit Bookings</h4>
            {{-- <button class="btn btn-danger px-4"
                x-data="{
                    isLoading: false,
                    alertConfirm() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'Delete all ongoing unit bookings?',
                            icon: 'question',
                            confirmButtonText: 'Yes',
                            confirmButtonColor: '#dc3545',
                            showCancelButton: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.isLoading = true; // Start spinner
                                $wire.deleteAll().then(() => {
                                    this.isLoading = false; // Stop spinner after completion
                                });
                            }
                        });
                    },
                }"
                x-on:click="alertConfirm"
                x-bind:disabled="{{ count($booking_queues) === 0 }}"
            >
                <template x-if="!isLoading">
                    <span>Delete All</span>
                </template>
                <template x-if="isLoading">
                    <span class="spinner-border spinner-border-sm text-light" role="status"
                        aria-hidden="true"></span>
                </template>
            </button> --}}
        </div>
        <div class="table-responsive" x-init="
            window.addEventListener('deleteSuccess', function(e) {
                Swal.fire('Queue Deleted!', '', 'success');
            });
            window.addEventListener('deleteError', function(e) {
                Swal.fire('Error!', 'Something went wrong in deleting the ongoing unit booking.', 'error');
            });
            window.addEventListener('deleteAllSuccess', function(e) {
                Swal.fire('All Booking Queue Deleted!', '', 'success');
            });
            window.addEventListener('deleteAllError', function(e) {
                Swal.fire('Error!', 'Something went wrong in deleting all ongoing unit booking.', 'error');
            });
        ">
            <table id="booking_queues" class="table">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Check-in</th>
                        <th scope="col">Check-out</th>
                        <th scope="col">Started</th>
                        <th scope="col">Timestamp</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($booking_queues as $booking)
                        <tr>
                            <td>{{ $booking->user->first_name . ' ' . $booking->user->last_name }}</td>
                            <td>{{ $booking->unit->name }}</td>
                            <td>{{ date('M j, Y', strtotime($booking->check_in)) }}</td>
                            <td>{{ date('M j, Y', strtotime($booking->check_out)) }}</td>
                            <td>{{ $booking->started }}</td>
                            {{-- <td>{{ \Illuminate\Support\Carbon::parse($booking->created_at)->diffForHumans() }}</td> --}}
                            <td>{{ date('h:i A - M j, Y', strtotime($booking->created_at)) }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" x-data="{
                                    isLoading: false,
                                    alertConfirm() {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: 'Delete this ongoing unit booking?',
                                            icon: 'question',
                                            confirmButtonText: 'Yes',
                                            confirmButtonColor: '#dc3545',
                                            showCancelButton: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                this.isLoading = true; // Start spinner
                                                $wire.deleteQueue({{ $booking->id }}).then(() => {
                                                    this.isLoading = false; // Stop spinner after completion
                                                });
                                            }
                                        });
                                    },
                                }"
                                    x-on:click="alertConfirm">
                                    <template x-if="!isLoading">
                                        <span>Delete</span>
                                    </template>
                                    <template x-if="isLoading">
                                        <span class="spinner-border spinner-border-sm text-light" role="status"
                                            aria-hidden="true"></span>
                                    </template>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center bg-secondary-subtle">No ongoing unit bookings</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
