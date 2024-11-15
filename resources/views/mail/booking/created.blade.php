{{-- <x-mail::message>
    Header with Logo and Contact Information
    <table style="width: 100%;">
        <tr>
            <td style="text-align: left; vertical-align: top;">
                
            </td>
            <td style="text-align: right; vertical-align: top;">
                <div style="font-size: 1.5rem; font-weight: 600;">Booking Information</div>
                <div style="font-size: 0.9rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-envelope-open-fill" viewBox="0 0 16 16">
                        <path
                            d="M8.941.435a2 2 0 0 0-1.882 0l-6 3.2A2 2 0 0 0 0 5.4v.314l6.709 3.932L8 8.928l1.291.718L16 5.714V5.4a2 2 0 0 0-1.059-1.765zM16 6.873l-5.693 3.337L16 13.372v-6.5Zm-.059 7.611L8 10.072.059 14.484A2 2 0 0 0 2 16h12a2 2 0 0 0 1.941-1.516M0 13.373l5.693-3.163L0 6.873z" />
                    </svg> <a href="mailto:pensionneestela@gmail.com">pensionneestela@gmail.com</a>
                </div>
                <div style="font-size: 0.9rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-telephone-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                    </svg> <a href="tel:+4709447433">470-944-7433</a>
                </div>
            </td>
        </tr>
    </table>
    <hr style="margin-bottom: 15px;">

    # Hello {{ $booking->first_name }},

    We are pleased to inform you that your booking has been successfully created. Thank you for booking with us!

    Here are your booking details:
    <x-mail::table>
        | | Details |
        | ------------------- | :-----------: |
        | Booking ID | #{{ $booking->reference_no }} |
        | Check-In Date | {{ \Carbon\Carbon::parse($booking->checkin_date)->format('M j, Y') }} |
        | Check-out Date | {{ \Carbon\Carbon::parse($booking->checkout_date)->format('M j, Y') }} |
        | Guests | {{ $booking->no_of_guests }} |
        | Down-paid Amount | ₱{{ number_format($booking->total_payment - $booking->outstanding_payment, 2) }} |
        | Outstanding Balance | ₱{{ number_format($booking->outstanding_payment, 2) }} |
        | Total Payment | ₱{{ number_format($booking->total_payment, 2) }} |
    </x-mail::table>

    <h3 style="margin-bottom: 0%;">Services Availed</h3>
    <x-mail::table>
        | Service Name | Details |
        | ------------------- | :-----------: |
        @forelse ($booking->services as $service)
            @if ($service->name == 'Meal Service')
                | Meal Service | {{ $service->service->details }} |
            @else
                | {{ $service->name }} | Quantity: {{ $service->service->quantity }} |
            @endif
        @empty
            | No services availed |
        @endforelse
    </x-mail::table>

    <x-mail::button :url="url('/')" color="primary">
        View Your Booking
    </x-mail::button>

    Thank you for choosing us. We look forward to your stay!

    @lang('Regards'),
    Pensionne Estela

    <x-slot:subcopy>
        If you have any issues viewing your booking, you may go directly on our website thru:
        [{{ url('/') }}]({{ url('/') }})
    </x-slot:subcopy>
</x-mail::message> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="font-family: 'Figtree';">
    {{-- <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {{ $header ?? '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0"
                            style="border: hidden !important;">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table> --}}
    <div class="container">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div
                    class="table-responsive"
                >
                    <table
                        class="table table-light"
                    >
                        <thead>
                            <tr>
                                <th scope="col">Column 1</th>
                                <th scope="col">Column 2</th>
                                <th scope="col">Column 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <td scope="row">R1C1</td>
                                <td>R1C2</td>
                                <td>R1C3</td>
                            </tr>
                            <tr class="">
                                <td scope="row">Item</td>
                                <td>Item</td>
                                <td>Item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
