<div id="booking_records" class="card rounded-4 border-0 shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="bookings" class="table small">
                <thead>
                    <tr>
                        <th scope="col" class="text-nowrap text-center">ID</th>
                        <th scope="col" class="text-nowrap text-center">Status</th>
                        <th scope="col" class="text-nowrap text-center">Guest Name</th>
                        <th scope="col" class="text-nowrap text-center">Phone Number</th>
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
                            <td class="text-nowrap text-center">#{{ $booking->reference_no }}</td>
                            <td class="text-nowrap text-center">
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
                            <td class="text-nowrap text-center">
                                <p class="mb-0 text-nowrap">{{ $booking->first_name . ' ' . $booking->last_name }}</p>
                            </td>
                            <td class="text-nowrap text-center">
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
                            <td class="text-nowrap ">
                                @if ($booking->services->count() == 0)
                                    <p class="mb-0 text-center fst-italic small text-muted">No services availed</p>
                                @else
                                    <ul class="mb-0">
                                        @foreach ($booking->services as $service)
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
                                        @endforeach
                                    </ul>
                                @endif

                            </td>
                            <td class="text-nowrap text-center">
                                &#8369;{{ number_format($booking->total_payment - $booking->outstanding_payment, 2) }}
                            </td>
                            <td class="text-nowrap text-center">
                                &#8369;{{ number_format($booking->outstanding_payment, 2) }}</td>
                            <td class="text-nowrap text-center">
                                &#8369;{{ number_format($booking->total_payment, 2) }}
                            </td>
                            <td class="text-nowrap text-center">
                                @if (is_null($booking->gcash_ref_no))
                                    <span class="text-muted fst-italic" data-bs-toggle="tooltip"
                                        data-bs-title="This person paid in cash.">Cash Transaction</span>
                                @else
                                    {{ $booking->gcash_ref_no }}
                                @endif
                            </td>
                            <td class="text-nowrap text-center">
                                {{ date('M j, Y', strtotime($booking->created_at)) }}
                            </td>
                            <td class="text-nowrap text-center">
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
        $(document).ready(function() {
            $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
            var table = $('#bookings').DataTable({
                // autoWidth: true,
                scrollCollapse: true,
                scrollY: '50vh',
                fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 1  // Freeze the last column on the right
                },
                columnDefs: [{
                        targets: 15,
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
                    topEnd: 'buttons',
                    bottomStart: 'paging',
                    bottomEnd: 'info'
                }
            });

            // $('#bookings').DataTable();
        });
    </script>
@endpush

{{-- <div id="booking_records" class="card rounded-4 border-0 shadow mb-4">
    <div class="card-body">
        <table id="bookings" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="text-nowrap text-center">ID</th>
                    <th scope="col" class="text-nowrap text-center">Status</th>
                    <th scope="col" class="text-nowrap text-center">Guest Name</th>
                    <th scope="col" class="text-nowrap text-center">Phone Number</th>
                    <th scope="col" class="text-nowrap text-center">Unit</th>
                    <th scope="col" class="text-nowrap text-center">Check In</th>
                    <th scope="col" class="text-nowrap text-center">Check Out</th>
                    <th scope="col" class="text-nowrap text-center"># of Guests</th>
                    <th scope="col" class="text-nowrap text-center">Nights</th>
                    <th scope="col" class="text-nowrap text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td class="text-nowrap text-center">#{{ $booking->reference_no }}</td>
                        <td class="text-nowrap text-center">
                            @switch($booking->status)
                                @case('pending')
                                    @if (!is_null($booking->reason_of_cancel))
                                        <span class="badge text-bg-warning fw-normal text-wrap">Waiting for cancellation
                                            approval</span>
                                    @else
                                        <span class="badge text-bg-warning fs-6 fw-normal">Pending</span>
                                    @endif
                                @break

                                @case('confirmed')
                                    @if (!is_null($booking->reason_of_cancel))
                                        <span class="badge text-bg-warning fw-normal">Waiting for cancellation approval</span>
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
                        <td class="text-nowrap text-center">
                            <p class="mb-0 text-nowrap">{{ $booking->first_name . ' ' . $booking->last_name }}</p>
                        </td>
                        <td class="text-nowrap text-center">
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
                            <i class="bi bi-moon-fill me-1"></i>
                            {{ \Carbon\Carbon::parse($booking->checkin_date)->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) }}
                        </td>
                        <td class="text-nowrap text-center">
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

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#bookings').DataTable({
                "columnDefs": [{
                    "targets": -1, // Adjust the index to match your "Action" column
                    "orderable": false,
                    "searchable": false
                }],
                "order": [
                    [0, "desc"]
                ], // Sort by ID column descending
                "responsive": true, // Make the table responsive
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('getallbookings') }}", // Replace with your data source route
                "columns": [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'first_name',
                        name: 'guest_name'
                    },
                    {
                        data: 'phone_no',
                        name: 'phone_number'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'checkin_date',
                        name: 'checkin_date'
                    },
                    {
                        data: 'checkout_date',
                        name: 'checkout_date'
                    },
                    {
                        data: 'no_of_guests',
                        name: 'no_of_guests'
                    },
                    {
                        data: 'nights',
                        name: 'nights'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "rowCallback": function(row, data, index) {
                    // Add a detail row button
                    $('td:eq(9)', row).html(
                        '<button type="button" class="btn btn-sm btn-primary btn-detail">Details</button>'
                        );

                    // Add a click event handler to the detail button
                    $('button.btn-detail', row).on('click', function() {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);

                        if (row.child.isShown()) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            // Open this row
                            row.child(format(data)).show();
                            tr.addClass('shown');
                        }
                    });
                }
            });

            function format(d) {
                // Format the detailed information for the child row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>Services Availed:</td>' +
                    '<td>' + d.services + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Down Payment:</td>' +
                    '<td>' + d.down_payment + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Outstanding Balance:</td>' +
                    '<td>' + d.outstanding_balance + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Total Payment:</td>' +
                    '<td>' + d.total_payment + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>GCash Reference #:</td>' +
                    '<td>' + d.gcash_ref_no + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>Date Created:</td>' +
                    '<td>' + d.created_at + '</td>' +
                    '</tr>' +
                    '</table>';
            }
        });
    </script>
@endpush --}}
