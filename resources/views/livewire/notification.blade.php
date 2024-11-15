<div x-data 
    x-init="
        Echo.private('users.{{ auth()->id() }}')
            .notification((notification) => {
                console.log(notification);
            });

        window.addEventListener('newToast', function(e) {
            Swal.fire({
                toast: true,
                position: 'center',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                icon: 'info',
                title: 'New Booking!',
                showConfirmButton: false,
                timer: 1600,
                timerProgressBar: true,
            });
        });
    "
    class="h-100 w-100"
>
    @if ($notifications->isEmpty())
        <div class="rounded-4 bg-secondary-subtle h-100 w-100 d-flex flex-column justify-content-center align-items-center">
            <div class="position-relative d-inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                    fill="currentColor" class="bi bi-bell-fill mb-2 text-secondary" viewBox="0 0 16 16">
                    <path
                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                </svg>
                <div class="position-absolute top-0 start-100 translate-middle badge rounded-circle border border-2 border-light-subtle text-bg-secondary fs-5">0</div>
            </div>
            <div class="fs-5 fw-semibold">No Notifications</div>
        </div>
    @else
        <div class="mb-3"
            x-data="{ markAllShow: true, isAllLoading: false }" 
            x-init="
                window.addEventListener('markAllSuccess', function(e) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Marked all notifications!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                    markAllShow = false;
                    isAllLoading = false;
                });
                window.addEventListener('markError', function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error in marking all notifications!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                    });
                    isAllLoading = false;
                });
            "
        >
            <button x-show="markAllShow" type="button"
                x-on:click="isAllLoading = true; $wire.markAll();"
                x-transition.duration.400ms :disabled="isAllLoading"
                class="btn btn-outline-primary icon-link rounded-3 fw-medium"
            >
                <span x-show="isAllLoading" style="display: none;"
                    class="spinner-border spinner-border-sm text-primary" role="status"
                    aria-hidden="true">
                </span>
                <span x-show="!isAllLoading">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                        <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
                    </svg>
                </span>
                Mark all as read
            </button>
        </div>
        @foreach ($notifications as $notification)
            @switch($notification->type)
                @case('booking-created')
                    @if ($user->usertype == "customer")
                        <x-notif-success
                            id="{{ $notification->id }}"
                            text="You just booked {{ $notification->data['unit_name'] }}."
                            time="{{ Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans() }}"
                            details="{{ route('bookings.show', $notification->data['booking_id']) }}"
                        />
                    @else
                        <x-notif-info
                            id="{{ $notification->id }}"
                            text="{{ $notification->data['first_name'] ?? 'No name' }} just booked {{ $notification->data['unit_name'] }}."
                            time="{{ Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans() }}"
                            details="{{ route('bookings.show', $notification->data['booking_id']) }}"
                        />
                    @endif
                    @break
                @case('booking-confirmed')
                    <x-notif-success
                        id="{{ $notification->id }}"
                        ref="#{{ $notification->data['reference_no'] }}"
                        text="booking is confirmed."
                        time="{{ Illuminate\Support\Carbon::parse($notification->created_at)->diffForHumans() }}"
                        details="{{ route('bookings.show', $notification->data['booking_id']) }}"
                    />
                    @break
                @default
            @endswitch
            @if ($loop->last && $user->usertype == 'manager')
                <div class="d-flex justify-content-center mb-2">
                    <a href="#" class="btn btn-darkgreen rounded-3 shadow-sm px-4" data-leave-check="true">
                        See all notifications
                    </a>
                </div>
            @endif
        @endforeach
    @endif
</div>
