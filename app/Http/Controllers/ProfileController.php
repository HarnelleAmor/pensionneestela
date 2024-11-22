<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking;
use App\Models\BookingQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        $no_bookings = Booking::where('user_id', $user->id)
            ->where(function (Builder $query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'confirmed')
                    ->orWhere('status', 'checked-in');
            })
            ->where('is_archived', 0)
            ->doesntExist();
        
        $no_booking_queue = BookingQueue::where('user_id', $user->id)->doesntExist();

        if ($no_bookings && $no_booking_queue) {
            $user->is_archived = true;
            if ($user->save()) {
                // send deactivation notification
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                alert()->success('Success', 'The account is deactivated.')->showConfirmButton('Okay', '#3085d6');
                return Redirect::to('/');
            } else {
                alert()->error('Error', 'Something went wrong in deactivating account')->showConfirmButton('Okay', '#3085d6');
                return redirect()->back();
            }
        } else {
            alert()->error('Error', 'Account has active bookings.')->showConfirmButton('Okay', '#3085d6');
            return back();
        }
    }
}
