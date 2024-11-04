@extends('layouts.manager')
@section('page', 'Bookings')
@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex justify-content-center">
            <ul class="nav-darkgreen nav-pills-darkgreen mb-3 gap-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-4 shadow active" id="pills-manage-bookings-tab" data-bs-toggle="pill" data-bs-target="#pills-manage-bookings" type="button" role="tab" aria-controls="pills-manage-bookings" aria-selected="true">Manage Bookings</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-4 shadow" id="pills-records-tab" data-bs-toggle="pill" data-bs-target="#pills-records" type="button" role="tab" aria-controls="pills-records" aria-selected="false">Booking Records</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-4 shadow" id="pills-reminder-tab" data-bs-toggle="pill" data-bs-target="#pills-reminder"
                        type="button" role="tab" aria-controls="pills-reminder" aria-selected="false">Send
                        Reminders</button>
                </li> --}}
            </ul>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-manage-bookings" role="tabpanel" aria-labelledby="pills-records-tab" tabindex="0">
                <livewire:manage-bookings/>
            </div>
            <div class="tab-pane fade" id="pills-records" role="tabpanel" aria-labelledby="pills-records-tab" tabindex="0">
                @include('bookings.indextabs.booking_records')
            </div>
            <div class="tab-pane fade" id="pills-reminder" role="tabpanel" aria-labelledby="pills-reminder-tab" tabindex="0">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Send Booking Reminder</h4>
        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="module">
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        </script>
    @endpush


@endsection
