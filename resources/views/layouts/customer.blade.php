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
        <style>
            body {
                font-family: 'Figtree' !important;
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/custom.js'])
    </head>
    <body class="font-sans antialiased">
        

        @if (session('success'))
            <script type="module">
                Swal.fire({
                    icon: "success",
                    title: "Booking Created!",
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

            {{-- Navigation Bar --}}
            @include('layouts.customer-nav')

            <div class="container-fluid pt-2 mb-4 min-vh-100" style="margin-top: 110px"
                x-data
                x-init="
                    Echo.private('users.{{auth()->id()}}')
                        .notification((notification) => {
                            if (notification.type === 'booking.created') {
                                console.log('A new booking was created: ', notification);
                            }
                        });
                "
            >
                @yield('content')
            </div>
        @include('layouts.footer')
        @include('sweetalert::alert')
        @stack('scripts')
    </body>
</html>
