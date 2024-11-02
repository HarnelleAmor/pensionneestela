<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-STELLA') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/customer.js'])
</head>
<body class="font-sans antialiased">
    <div class="container-fluid pt-5 min-vh-100 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body p-5">
                        <h4 class="text-center mb-4 text-dark">Booking Terms and Conditions</h4>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Payment:</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success"></i> Payment must be made via GCash.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> The GCash number and QR code will be provided upon booking.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Payment should be made as soon as possible to confirm the reservation.</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Check-in/Check-out:</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success"></i> There is no standard check-in time.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Check-out time is noon.</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Cancellation Policy:</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success"></i> If a guest fails to notify the manager of a cancellation through the system, Facebook Messenger, or text message/calls, the booking will be forfeited.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> The downpayment paid will not be refunded for no-shows.</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Pet Policy:</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success"></i> Pensionne Estela is pet-friendly.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Guests are responsible for cleaning up after their pets and ensuring they do not cause any damage to the property.</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Liability:</h5>
                            <p>Pensionne Estela is not liable for any loss or damage of guests' valuables. Guests are responsible for any damage caused during their stay.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Smoking Policy:</h5>
                            <p>Smoking is strictly prohibited inside the transient units.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fs-5 text-primary">Additional Terms:</h5>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle-fill text-success"></i> Guests are responsible for adhering to all rules and regulations set forth by Pensionne Estela.</li>
                                <li><i class="bi bi-check-circle-fill text-success"></i> Pensionne Estela reserves the right to modify these terms and conditions without prior notice.</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        function toggleTermsNConditions() {
            const checkbox = document.getElementById('termsAgreement');
            const proceedButton = document.getElementById('proceedPayment');
            proceedButton.disabled = !checkbox.checked; 
        }
    </script>
</body>
</html>
