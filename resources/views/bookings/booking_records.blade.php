<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Report</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js',])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            padding: 30px;
            color: #333;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        /* Logo styles */
        .logo {
            height: 80px;
            margin-bottom: 20px;
        }

        /* Heading styles */
        h1 {
            margin-bottom: 30px;
            font-size: 24px;
            color: #270D05;
            border-bottom: 2px solid #CFC697;
            display: inline-block;
            padding-bottom: 10px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 15px;
            font-size: 14px;
        }

        th {
            background-color: #CFC697;
            font-weight: bold;
            color: #270D05;

        }

        /* Status styles */
        .status-pending {
            color: orange;
        }

        .status-confirmed {
            color: green;
        }

        .status-checked-in {
            color: blue;
        }

        .status-checked-out {
            color: darkgreen;
        }

        .status-no-show {
            color: red;
        }

        .status-cancelled {
            color: darkred;
        }

        /* Footer styles */
        footer {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
            color: #777;
        }

        @page {
            size: portrait;
            margin: 20mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="{{ asset('assets/images/estella.png') }}" alt="Pensionne Estela" class="logo">
        <h1>Booking Records</h1>
    </div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Number of Guests</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Status</th>
                <th>Total Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($filteredBookings as $booking)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                <td>{{ $booking->email }}</td>
                <td>{{ $booking->no_of_guests }}</td>
                <td>{{ $booking->checkin_date }}</td>
                <td>{{ $booking->checkout_date }}</td>
                <td>
                    <span class="status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span>
                </td>
                <td>{{ number_format($booking->total_payment, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

     <!-- Total Payment Sum -->
     <div style="margin-top: 20px;">
        <h4>Total Payment Sum: ₱{{ number_format($totalPaymentSum, 2) }}</h4>
    </div>

    <footer>
        &copy; {{ date('Y') }} Pensionne Estela. All rights reserved.
    </footer>
</body>

</html>