<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $units = Unit::with(['photos', 'amenities', 'bookings'])->get();
        foreach ($units as $unit) {
            $booking = Booking::where('unit_id', $unit->id)
                ->where(function (Builder $query) {
                    $query->where('checkin_date', Carbon::today())->orWhere('checkout_date', Carbon::today());
                })
                ->where('status', 'checked-in')
                ->where('is_archived', false)
                ->first();
            if (!is_null($booking)) {
                $unit->is_available = false;
            } else {
                $unit->is_available = true;
            }
        }
        return view('units.unit_index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        return view('units.unit_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'occupancy_limit' => 'required|integer|min:1',
            'bed_configuration' => 'required|string|max:255',
            'view' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
        ]);

        // $path = null;
        // if ($request->has('image')) {
        //     $file = $request->file('image');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $path = 'uploads/unit/';
        //     $file->move($path, $filename);
        // }

        $unit = new Unit();

        $unit->name = $request->unit_name;
        $unit->occupancy_limit = $request->occupancy_limit;
        $unit->bed_config = $request->bed_configuration;
        $unit->view = $request->view;
        $unit->location = $request->location;
        $unit->price_per_night = $request->price_per_night;

        if ($unit->save()) {
            return redirect()->back()->with('success', 'Unit created successfully.');
        } else {
            return back()->withInput()->with('error', 'Something went wrong in creating a unit.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        Gate::authorize('is-manager');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        Gate::authorize('is-manager');
        $unit->load(['photos', 'amenities']);
        // dd($unit->amenities->contains(35));
        $amenities = Amenity::all();
        foreach ($amenities as $amenity) {
            if ($unit->amenities->contains($amenity->id)) {
                $amenity->is_checked = true;
            }
        }
        return view('units.unit_edit', compact('unit', 'amenities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        Gate::authorize('is-manager');
        $request->validate([
            'unit_name' => 'required|string|max:255',
            'occupancy_limit' => 'required|integer|min:1',
            'bed_configuration' => 'required|string|max:255',
            'view' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
        ]);

        // $path = $unit->image;

        // if ($request->has('image')) {
        //     $file = $request->file('image');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $path = 'uploads/unit/';
        //     $file->move($path, $filename);
            
        //     if (File::exists($unit->image)) {
        //         File::delete($unit->image);
        //     }

        //     $path = $path . $filename;
        // }

        $unit->name = $request->unit_name;
        $unit->occupancy_limit = $request->occupancy_limit;
        $unit->bed_config = $request->bed_configuration;
        $unit->view = $request->view;
        $unit->location = $request->location;
        $unit->price_per_night = $request->price_per_night;

        if ($unit->save()) {
            return redirect()->back()->with('success', $unit->name . ' updated successfully.');
        } else {
            return back()->withInput()->with('error', 'Something went wrong in updating ' . $unit->name . '.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        Gate::authorize('is-manager');
        // if (File::exists($unit->image)) {
        //     File::delete($unit->image);
        // }
        if ($unit->delete()) {
            return redirect()->back()->with('status', $unit->name . ' deleted successfully');
        } else {
            return back()->with('error', 'Something went wrong in deleting ' . $unit->name . '.');
        }
        

        
    }
}
