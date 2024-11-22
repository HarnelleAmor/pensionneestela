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
    <div class="container-fluid pt-2 min-vh-100 mb-3 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded-5 shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold text-center mb-4">Privacy Policy</h4>

                        <!-- Privacy Policy Section -->
                        <div class="mb-4">
                            <p>Your personal data is handled in compliance with the <strong>Data Privacy Act of 2012</strong> (Philippines) and the <strong>General Data Protection Regulation (GDPR)</strong>. By booking with Pensionne Estela, you consent to the collection, storage, and use of your data for reservation and communication purposes. We ensure the security and confidentiality of your information.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-semibold">1. Data Collection and Use</h5>
                            <p>We collect personal information from guests when they make reservations. The types of information we may collect include:</p>
                            <ul class="list-unstyled ms-3">
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Full Name</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Phone Number</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Email Address</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Booking Dates</li>
                                <li><i class="bi bi-check-circle-fill text-primary"></i> Payment Information (GCash Transaction Reference Number)</li>
                            </ul>
                            <p>This information is essential for processing reservations, managing bookings, and delivering exceptional service. We do not share your personal information with third parties unless required by law or to fulfill your booking.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-semibold">2. Data Security</h5>
                            <p>We implement industry-standard security measures to protect your personal information from unauthorized access, use, or disclosure. We are committed to ensuring that your data is handled with care and diligence.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-semibold">3. Data Retention</h5>
                            <p>Your data will be retained for one year following the completion of your booking. This retention is necessary for record-keeping and to comply with applicable legal requirements.</p>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-semibold">4. Data Access and Correction</h5>
                            <p>You have the right to access and correct your personal information at any time. To do so, simply log into your account on our website and navigate to your profile. If you have any questions or concerns regarding your data, please reach out to us at <a href="mailto:pensionneestella@gmail.com" class="link-primary">pensionneestella@gmail.com</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
