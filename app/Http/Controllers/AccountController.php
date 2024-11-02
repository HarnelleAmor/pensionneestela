<?php

namespace App\Http\Controllers;

use App\Jobs\SendBookingEmail;
use App\Mail\SampleMail;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $accounts = User::all();
        return view('accounts.account_index', compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        // $user = User::find(Auth::user()->id);
        // $user->notify(new BookingCreated(Booking::find(24)));
        // return (new BookingCreated(Booking::first()))->toMail(Booking::with('user')->first()->user);
        // Mail::to('harnelleamor@gmail.com')->queue(new SampleMail(Booking::first()));
        // return (new SampleMail(Booking::first()))->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $account)
    {
        Gate::authorize('is-manager');

        $account->load('bookings');
        return view('accounts.account_show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $account)
    {
        Gate::authorize('is-manager');


        return  view('accounts.account_edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $account)
    {
        Gate::authorize('is-manager');

        // Validate the incoming request
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($account->id)],
            'phone_no' => ['required', 'regex:/^09\d{9}$/'],
            'usertype' => ['required', Rule::in(['customer', 'manager'])]
        ]);

        // Fill the account model with only validated fields
        $account->fill($request->only(['first_name', 'last_name', 'email', 'phone_no', 'usertype']));

        // Check if the model is dirty before saving to avoid unnecessary update
        if ($account->isDirty()) {
            try {
                $account->save();

                Alert::success('Success', 'The account is updated.');
                return redirect()->back();
            } catch (\Exception $e) {
                // Log the error for debugging (optional)
                Log::error('Error updating account: ' . $e->getMessage());

                Alert::error('Error', 'Error: '. $e->getMessage());
                return redirect()->back();
            }
        }

        Alert::info('No Update', 'No changes detected in the account details.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $account)
    {
        Gate::authorize('is-manager');
        // 
    }

    public function deactivate(User $account)
    {
        Gate::authorize('is-manager');
        
        $account->is_archived = true;
        if ($account->save()) {
            Alert::success('Success', 'The account is deactivated.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Something went wrong in deactivating account');
            return redirect()->back();
        }
    }

    public function activate(User $account)
    {
        Gate::authorize('is-manager');
        
        $account->is_archived = true;
        if ($account->save()) {
            Alert::success('Success', 'The account is deactivated.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Something went wrong in deactivating account');
            return redirect()->back();
        }
    }
}
