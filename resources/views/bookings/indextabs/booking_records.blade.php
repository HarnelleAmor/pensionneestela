<div id="booking_records" class="card rounded-4 border-0 shadow mb-4">
    <div class="card-body">
        {{-- <h3 class="fw-semibold text-center mb-1">Booking Records</h3> --}}
        <div class="table-responsive">
            <table id="bookings" class="table table-secondary">
                <thead>
                    <tr>
                        {{-- <th></th> --}}
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
                        <th scope="col" class="text-nowrap text-center">Date Created</th>
                        <th scope="col" class="text-nowrap text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            {{-- <td></td> --}}
                            <td class="=> text-center">#{{ $booking->reference_no }}</td>
                            <td class="=> text-center">
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
                            <td class="=>">
                                <p class="mb-0">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                                <p class="mb-0 fst-italic small">{{ $booking->phone_no }}</p>
                            </td>
                            <td class="=> text-center">
                                {{ $booking->unit->name }}
                            </td>
                            <td class="=> text-center">
                                {{ date('M j, Y', strtotime($booking->checkin_date)) }}
                            </td>
                            <td class="=> text-center">
                                {{ date('M j, Y', strtotime($booking->checkout_date)) }}
                            </td>
                            <td class="=> text-center">
                                <i class="bi bi-people-fill me-1"></i>{{ $booking->no_of_guests }}
                            </td>
                            <td class="=> text-center">
                                <i
                                    class="bi bi-moon-fill me-1"></i>{{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                            </td>
                            <td class="=>">
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
                    <td class="=> text-center">
                        &#8369;{{ number_format($booking->total_payment - $booking->outstanding_payment, 2) }}
                    </td>
                    <td class="=> text-center">
                        &#8369;{{ number_format($booking->outstanding_payment, 2) }}</td>
                    <td class="=> text-center">
                        &#8369;{{ number_format($booking->total_payment, 2) }}
                    </td>
                    <td class="=> text-center">
                        @if (is_null($booking->gcash_ref_no))
                            <span class="text-muted fst-italic" data-bs-toggle="tooltip"
                                data-bs-title="This person paid in cash.">Cash Transaction</span>
                        @else
                            {{ $booking->gcash_ref_no }}
                        @endif
                    </td>
                    <td class="=> text-center">
                        {{ date('M j, Y', strtotime($booking->created_at)) }}
                    </td>
                    <td class="=> text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sage btn-sm">
                                View
                            </a>
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
        $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
        var table = $('#bookings').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1  // Freeze the last column on the right
            },
            columnDefs: [
                {
                    targets: 14,
                    searchable: false,
                    orderable: false
                },
                // {
                //     targets: 0,
                //     render: DataTable.render.select(),
                //     orderable: false
                // }
            ],
            // select: {
            //     style: 'os',
            //     selector: 'td:first-child'
            // },
            "scrollY": "25rem",
            "scrollCollapse": true,
            "paging": true,
            buttons: [{
                    extend: 'colvis',
                    text: '<i class="bi bi-eye me-1"></i> Toggle Columns ',
                    className: 'buttons-collection buttons-colvis btn-primary btn-sm me-2 rounded'
                },
                {
                    extend: 'csvHtml5',
                    text: 'CSV<i class="bi bi-download ms-1"></i>',
                    className: 'buttons-csv buttons-html5 btn-success btn-sm rounded-start'
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF<i class="bi bi-download ms-1"></i>',
                    className: 'buttons-pdf btn-info btn-sm',
                    filename: 'bookingspdf',
                    download: 'open',
                    orientation: 'landscape',
                    title: 'Booking Records as of {{ date('M j, Y', strtotime(now())) }}',
                    messageTop: 'Number of Records: {{ $bookings->count() }}',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13],
                    }
                },
                {
                    extend: 'print',
                    text: 'Print<i class="bi bi-printer ms-1"></i>',
                    className: 'buttons-print btn-secondary btn-sm rounded-end'
                },
            ],
            layout: {
                top2Start: 'searchBuilder',
                topStart: 'pageLength',
                top2End: {
                    search: {
                        placeholder: 'Type keywords here'
                    }
                },
                topEnd: 'buttons'
            }
        });
    </script>
@endpush