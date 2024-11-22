<div id="booking_records" class="card rounded-4 border-0 shadow mb-4">
    <div class="card-header d-flex justify-content-between align-items-center rounded-top-4 bg-white">
        <h5 class="mb-0"><i class="bi bi-filter me-1"></i>Filters</h5>
        <div class="row justify-content-end align-items-start g-2">
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <label class="input-group-text bg-white border-end-0 rounded-start-3" for="br_monthFilter">By Month:</label>
                    <select id="br_monthFilter" class="form-select rounded-end-3 border-start-0">
                        <option value="all" selected>All</option>         
                        <option value="Jan">January</option>  
                        <option value="Feb">February</option> 
                        <option value="Mar">March</option>    
                        <option value="Apr">April</option>    
                        <option value="May">May</option>      
                        <option value="Jun">June</option>     
                        <option value="Jul">July</option>     
                        <option value="Aug">August</option>   
                        <option value="Sep">September</option>
                        <option value="Oct">October</option>  
                        <option value="Nov">November</option> 
                        <option value="Dec">December</option> 
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <label class="input-group-text bg-white border-end-0 rounded-start-3" for="br_yearFilter">By Year:</label>
                    <select id="br_yearFilter" class="form-select rounded-end-3 border-start-0">
                        <option value="all" selected>All</option>
                        @foreach ($distinct_years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="input-group input-group-sm">
                    <input type="text" id="tableSearch" class="form-control border-end-0 rounded-start-3"
                        placeholder="Type any keyword here...">
                    <span class="input-group-text bg-white border-start-0 rounded-end-3 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="bookings" class="table small" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col" class="text-nowrap text-center">ID</th>                     <!-- 0 -->
                        <th scope="col" class="text-nowrap text-center">Status</th>                 <!-- 1 -->
                        <th scope="col" class="text-nowrap text-center">Guest Name</th>             <!-- 2 -->
                        <th scope="col" class="text-nowrap text-center">Phone Number</th>           <!-- 3 -->
                        <th scope="col" class="text-nowrap text-center">Unit</th>                   <!-- 4 -->
                        <th scope="col" class="text-nowrap text-center">Check In</th>               <!-- 5 -->
                        <th scope="col" class="text-nowrap text-center">Check Out</th>              <!-- 6 -->
                        <th scope="col" class="text-nowrap text-center"># of Guests</th>            <!-- 7 -->
                        <th scope="col" class="text-nowrap text-center">Nights</th>                 <!-- 8 -->
                        <th scope="col" class="text-nowrap text-center">Services Availed</th>       <!-- 9 -->
                        <th scope="col" class="text-nowrap text-center">Down Payment</th>           <!-- 10 -->
                        <th scope="col" class="text-nowrap text-center">Outstanding Balance</th>    <!-- 11 -->
                        <th scope="col" class="text-nowrap text-center">Damage Fees</th>            <!-- 12 -->
                        <th scope="col" class="text-nowrap text-center">Total Payment</th>          <!-- 13 -->
                        <th scope="col" class="text-nowrap text-center">GCash Reference #</th>      <!-- 14 -->
                        <th scope="col" class="text-nowrap text-center">Cash Payment</th>           <!-- 15 -->
                        <th scope="col" class="text-nowrap text-center">Date Created</th>           <!-- 16 -->
                        <th scope="col" class="text-nowrap text-center">Action</th>                 <!-- 17 -->
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
                                &#8369;{{ number_format($booking->outstanding_payment, 2) }}
                            </td>
                            <td class="text-nowrap text-center">
                                @if ($booking->damage_fee)
                                    &#8369;{{ number_format($booking->damage_fee, 2) }}
                                @else
                                    <span class="text-muted fst-italic">Null</span>
                                @endif
                            </td>
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
                                @if ($booking->cash_amount)
                                    &#8369;{{ number_format($booking->cash_amount, 2) }}
                                @else
                                    <span class="text-muted fst-italic">Null</span>
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
            DataTable.Buttons.jszip();
            $.fn.dataTable.Buttons.defaults.dom.button.className = 'btn';
            $.fn.dataTable.ext.type.order['date-mjs-pre'] = function (date) {
                return moment(date, 'MMM D, YYYY').valueOf(); // Parse date to timestamp
            };
            var table = $('#bookings').DataTable({
                scrollCollapse: true,
                scrollY: '50vh',
                scrollX: 'true',
                order: [],
                fixedColumns: {
                    leftColumns: 0,
                    rightColumns: 1
                },
                columnDefs: [
                    {
                        targets: 5,
                        type: 'date-mjs',
                    },
                    {
                        targets: 6,
                        type: 'date-mjs', 
                    },
                    {
                        targets: 16,
                        type: 'date-mjs',
                    },
                    {
                        targets: 17,
                        searchable: false,
                        orderable: false
                    }
                ],
                buttons: [{
                        extend: 'colvis',
                        text: '<i class="bi bi-layout-three-columns me-1"></i>Columns ',
                        className: 'buttons-collection buttons-colvis btn-outline-secondary btn-sm me-2 rounded'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel<i class="bi bi-file-earmark-excel ms-1"></i>',
                        className: 'buttons-excel btn-success btn-sm rounded-start',
                        exportOptions: {
                            modifier: {
                                page: 'current' // Exports only the current page rows
                            },
                            columns: ':visible' // Exports only visible columns
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF<i class="bi bi-file-earmark-pdf ms-1"></i>',
                        className: 'buttons-pdf btn-info btn-sm',
                        filename: 'bookingspdf',
                        download: 'open',
                        orientation: 'landscape',
                        title: 'Booking Records as of {{ date('M j, Y', strtotime(now())) }}',
                        messageTop: 'Number of Records: {{ $bookings->count() }}',
                        exportOptions: {
                            columns: ':visible' // Exports only visible columns
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print<i class="bi bi-printer ms-1"></i>',
                        className: 'buttons-print btn-secondary btn-sm rounded-end',
                        exportOptions: {
                            columns: ':visible' // Exports only visible columns
                        }
                    }
                ],
                layout: {
                    topStart: 'pageLength',
                    topEnd: 'buttons',
                    bottomStart: 'paging',
                    bottomEnd: 'info'
                }
            });
            $("#pills-records-tab").on('click', function (e) {
                table.columns.adjust().draw();
            });

            // Filter table based on month selection
            $('#br_monthFilter').on('change', function () {
                var selectedMonth = $(this).val(); // Get the selected month (e.g., "Jan", "Feb")

                if (selectedMonth === "all") {
                    // Reset the filter if 'All' is selected
                    table.column(5).search('').column(6).search('').draw();
                } else {
                    // Regex to match the selected month in both "Check In" and "Check Out" columns
                    var regex = '^' + selectedMonth; // Match starting with the selected month (e.g., "Jan")
                    table
                        .column(5).search(regex, true, false) // Apply search to "Check In" column (6th)
                        .column(6).search(regex, true, false) // Apply search to "Check Out" column (7th)
                        .draw();
                }
            });

            // Filter table based on year selection
            $('#br_yearFilter').on('change', function () {
                var selectedYear = $(this).val(); // Get the selected year (e.g., "2024")

                if (selectedYear === "all") {
                    // Reset the filter if 'All' is selected
                    table.column(5).search('').column(6).search('').draw();
                } else {
                    // Regex to match the selected year in both "Check In" and "Check Out" columns
                    var regex = selectedYear + '$'; // Match starting with the selected year (e.g., "2024")
                    table
                        .column(5).search(regex, true, false) // Apply search to "Check In" column (6th)
                        .column(6).search(regex, true, false) // Apply search to "Check Out" column (7th)
                        .draw();
                }
            });

            $('#tableSearch').on('keyup', function() {
                table.search(this.value).draw(); // Perform the search and update the table
            });

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
