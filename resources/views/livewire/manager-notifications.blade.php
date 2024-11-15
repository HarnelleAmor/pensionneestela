<div class="card rounded-3">
    <div class="card-body">
        <div class="overflow-auto">
            @foreach ($notifications as $notification)
                @switch($notification->type)
                    @case('booking-created')
                        <div class="border p-3">{{ $notification->data['booking_id'] }}</div>
                    @break

                    @case('booking-confirmed')
                    @break

                    @default
                @endswitch
            @endforeach
        </div>
    </div>
</div>
