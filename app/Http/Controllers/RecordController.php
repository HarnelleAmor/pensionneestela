<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;

class RecordController extends Controller
{
    // SEARCH CRITERIA
    public function search(Request $request)
    {
        $name = $request->input('name');
        $status = $request->input('status');
        $unitId = $request->input('unit_id');
        $email = $request->input('email');
        $checkinDate = $request->input('checkin_date');
        $checkoutDate = $request->input('checkout_date');

        $bookings = Booking::query();

        if ($name) {
            $bookings->where(function ($query) use ($name) {
                $query->where('first_name', 'like', '%' . $name . '%')
                      ->orWhere('last_name', 'like', '%' . $name . '%');
            });
        }

        if ($status) {
            $bookings->where('status', $status);
        }

        if ($unitId) {
            $bookings->where('unit_id', $unitId);
        }

        if ($email) {
            $bookings->where('email', 'like', '%' . $email . '%');
        }

        if ($checkinDate && $checkoutDate) {
            $bookings->whereBetween('checkin_date', [$checkinDate, $checkoutDate]);
        }

        $bookings->orderBy('created_at', 'desc');

        // Calculate the total sum of payments for filtered bookings
        $totalPaymentSum = $bookings->sum('total_payment');

        $filteredBookings = $bookings->paginate(4);

        $units = Unit::all();

        session()->put('filteredBookingsAll', $filteredBookings);
        session()->put('totalPaymentSum', $totalPaymentSum); // Store total payment sum 

        return view('managerdashboard.m-record', compact('filteredBookings', 'units', 'totalPaymentSum'));
    }

    // Generate PDF report of filtered bookings
    public function generateReport(Request $request)
    {

        $filteredBookings = session('filteredBookingsAll');
        $totalPaymentSum = session('totalPaymentSum'); // Retrieve total payment sum from session


        $pdf = Pdf::loadView('bookings.booking_records', compact('filteredBookings', 'totalPaymentSum'));

        // Download the PDF as 'Booking Record.pdf'
        return $pdf->download('Booking Record.pdf');
    }

    // View the filtered booking records without downloading the PDF
    public function viewRecords(Request $request)
    {

        $filteredBookings = session('filteredBookingsAll');
        $totalPaymentSum = session('totalPaymentSum'); // Retrieve total payment sum from session

        return view('bookings.booking_records', compact('filteredBookings', 'totalPaymentSum'));
    }
}
