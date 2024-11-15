<?php

use App\Events\BookingCreated;
use App\Events\Example;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BackupRestoreController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\UnitCheckController;
use App\Http\Controllers\UnitController;
use App\Http\Middleware\NoGetMethod;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Notifications\BookingCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/hompage/units', [HomeController::class, 'units'])->name('home-units');
Route::get('/homepage/gallery', [HomeController::class, 'gallery'])->name('home-gallery');
Route::get('/hompage/about', [HomeController::class, 'about'])->name('home-about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/c-dashboard', [DashboardController::class, 'customerDashboard'])->name('customerdashboard');
    Route::get('/m-dashboard', [DashboardController::class, 'managerDashboard'])->name('managerdashboard');

    Route::resource('bookings', BookingController::class)->except('create');
    Route::controller(BookingController::class)->group(function () {
        Route::get('bookingsjson', 'getAllBookings')->name('getallbookings');

        Route::get('booking/form', 'createBookingForm')->name('booking.formCreate');
        Route::post('booking/form', 'postBookingForm')->name('booking.formStore');
        Route::get('booking/form/payment', 'getBookingPay')->name('booking.payCreate');
        Route::get('rebooking/form/{booking}', 'createRebookingForm')->name('rebooking.formCreate');
        Route::patch('rebooking/form/{booking}', 'postRebookingForm')->name('rebooking.formStore');
        $uris = [
            'unit/selected',
            'booking/cancel/{booking}',
            'booking/confirm/{booking}',
            'booking/noshow/{booking}',
            'booking/checkin/{booking}',
            'booking/checkout/{booking}',
            'booking/services/{booking}',
            'booking/deletequeue'
        ];
        
        foreach ($uris as $uri) {
            Route::get($uri, function () {
                abort(404);
            });
        }

        Route::post('unit/selected', 'postSelectedUnit')->name('unit.selected');
        Route::patch('booking/cancel/{booking}', 'cancelBooking')->name('booking.cancel');
        Route::patch('booking/confirm/{booking}', 'confirmBooking')->name('booking.confirm');
        Route::patch('booking/noshow/{booking}', 'noshowBooking')->name('booking.noshow');
        Route::patch('booking/checkin/{booking}', 'checkinBooking')->name('booking.checkin');
        Route::patch('booking/checkout/{booking}', 'checkoutBooking')->name('booking.checkout');
        Route::patch('booking/services/{booking}', 'updateServices')->name('booking.updateServices');
        Route::post('booking/deletequeue', 'deleteQueue')->name('booking.deleteQueue');
    });

    // Route::get('records/search', [RecordController::class, 'search'])->name('record.search');
    // Route::post('records/generate', [RecordController::class, 'generateReport'])->name('record.generate');
    // Route::get('records/view', [RecordController::class, 'viewRecords'])->name('record.view');

    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notifications', 'index')->name('notifs.index');
        Route::get('/unreadnotifications', 'unreadNotifs')->name('unread.index');
    });
    
    // TODO: redirect any POST/PUT/PATCH/DELETE illegal attempt back
    // TODO: Gate if unauthorized user

    Route::resource('accounts', AccountController::class);
    Route::match(['put', 'patch'], 'accounts/deactivate/{account}', [AccountController::class, 'deactivate'])->name('account.deactivate');
    Route::match(['put', 'patch'], 'accounts/activate/{account}', [AccountController::class, 'activate'])->name('account.activate');

    Route::resource('units', UnitController::class);

    Route::resource('amenities', AmenityController::class);

    Route::resource('photos', PhotoController::class);

    Route::resource('audits', AuditController::class)->only(['index']);

    Route::get('backuprestore', [BackupRestoreController::class, 'index'])->name('backuprestore.index');
    Route::post('backuprestore', [BackupRestoreController::class, 'downloadBackup'])->name('backuprestore.download');
    Route::post('backuprestorenow', [BackupRestoreController::class, 'backupDB'])->name('backuprestore.now');

    // pacheck din ito kung tama lang ginawa hehe

    // Route::get('/m-booking', function () {
    //     return view('managerdashboard.m-booking');
    // })->name('managebooking');

    // Route::get('/m-report', function () {
    //     return view('managerdashboard.m-report');
    // })->name('report');

});

Route::get('unit/check', [UnitCheckController::class, 'checkUnitPage'])->name('showUnitCheckPage');
Route::get('search', [UnitCheckController::class, 'searchAvailUnit'])->name('unit.search');

Route::get('privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('terms-and-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('tests', function (Request $request) {
    if ($request->session()->has('booking')) {
        dump('there is a booking');
        dump($request->session()->get('booking'));
        dump($request->session()->get('booking_downpayment'));
        dump($request->session()->get('sessionServices'));
    } else {
        dump('there is no booking');
    }
});

Route::get('broadcast', function () {
    // broadcast(new Example(Booking::first()));
    BookingCreated::dispatch(Booking::find(28));
});

Route::get('/test', function () {
    return view('test');
});

Route::get('testMail', function () {
    $booking = Booking::find(23);
    // BookingCreated::dispatch($booking);
    return (new BookingCreatedNotification($booking))->toMail($booking->user);

    // Notification::route('mail', 'harnelleamor@gmail.com')
    //             ->notify(new BookingCreatedNotification($booking));
});

Route::get('testDelete', function () {
    $booking = Booking::find(28);
    $booking->delete();
});