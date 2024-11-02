{{-- <x-mail::message> --}}
{{-- Greeting --}}
{{-- @if (!empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif --}}

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}

@endforeach

<x-mail::panel>
This is the panel content.
</x-mail::panel>

<x-mail::table>
| Laravel       | Table         | Example       |
| ------------- | :-----------: | ------------: |
| Col 2 is      | Centered      | $10           |
| Col 3 is      | Right-Aligned | $20           |
</x-mail::table> --}}

{{-- Action Button --}}
{{-- @isset($actionText)
<php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset --}}

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}

{{-- Salutation --}}
{{-- @if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards,')<br>
{{ config('app.name') }}
@endif --}}

{{-- Subcopy --}}
{{-- @isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message> --}}


<x-mail::message>
{{-- Greeting --}}
@if (!empty($greeting))
# {{ $greeting }}
@endif

{{-- Intro --}}
Thank you for booking with us! Here are your booking details:

{{-- Booking Summary Table --}}
<x-mail::panel>
<table style="width:100%; margin-top: 20px; border-collapse: collapse;">
    <tr>
        <td><strong>Booking ID:</strong></td>
        <td>#{{ $booking->reference_no }}</td>
    </tr>
    <tr>
        <td><strong>Check-In Date:</strong></td>
        <td>{{ \Carbon\Carbon::parse($booking->checkin_date)->format('M j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Check-Out Date:</strong></td>
        <td>{{ \Carbon\Carbon::parse($booking->checkout_date)->format('M j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Guests:</strong></td>
        <td>{{ $booking->no_of_guests }}</td>
    </tr>
    <tr>
        <td><strong>Total Payment:</strong></td>
        <td>${{ number_format($booking->total_payment, 2) }}</td>
    </tr>
</table>
</x-mail::panel>

{{-- Action Button --}}
<x-mail::button :url="$actionUrl" color="primary">
View Your Booking
</x-mail::button>

{{-- Closing --}}
Thank you for choosing us. We look forward to your stay!

@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
<x-slot:subcopy>
If you have any issues viewing your booking, copy and paste this URL into your browser: [{{ $displayableActionUrl }}]({{ $actionUrl }})
</x-slot:subcopy>
</x-mail::message>

