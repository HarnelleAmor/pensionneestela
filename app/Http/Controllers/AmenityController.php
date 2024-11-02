<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $data = Amenity::paginate(10); // Paginate results
        $totalAmenities = Amenity::count(); // Count total amenities

        return view('amenities.view_amenity', compact('data', 'totalAmenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        return view('amenities.create_amenity');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:bedroom,bathroom,kitchen,comforts',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle file upload for the icon
        $iconName = time() . '.' . $request->icon->extension();
        $request->icon->move(public_path('icons'), $iconName);

        // Create a new amenity
        Amenity::create([
            'name' => $request->name,
            'category' => $request->category,
            'icon' => $iconName,
        ]);

        return redirect()->route('view_amenity')->with('success', 'Amenity added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Amenity $amenity)
    {
        Gate::authorize('is-manager');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amenity $amenity)
    {
        Gate::authorize('is-manager');
        $amenity = Amenity::find($amenity->id);

        if (!$amenity) {
            return redirect()->route('view_amenity')->with('error', 'Amenity not found.');
        }

        return view('amenities.edit_amenity', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amenity $amenity)
    {
        Gate::authorize('is-manager');
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:bedroom,bathroom,kitchen,comforts',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $amenity = Amenity::find($request->amenity_id);

        if (!$amenity) {
            return redirect()->route('view_amenity')->with('error', 'Amenity not found.');
        }

        // Update the icon if a new one is uploaded
        if ($request->hasFile('icon')) {
            // Delete the old icon
            if (file_exists(public_path('icons/' . $amenity->icon))) {
                unlink(public_path('icons/' . $amenity->icon));
            }

            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('icons'), $iconName);

            $amenity->icon = $iconName;
        }

        // Update the amenity details
        $amenity->update([
            'name' => $request->name,
            'category' => $request->category,
            'icon' => $amenity->icon ?? $amenity->icon, // Keep old icon if no new icon is uploaded
        ]);

        return redirect()->route('view_amenity')->with('success', 'Amenity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity $amenity)
    {
        Gate::authorize('is-manager');
        $amenity = Amenity::find($amenity->id);

        if (!$amenity) {
            return redirect()->route('view_amenity')->with('error', 'Amenity not found.');
        }

        // Delete the icon file
        if (file_exists(public_path('icons/' . $amenity->icon))) {
            unlink(public_path('icons/' . $amenity->icon));
        }

        $amenity->delete();

        return redirect()->route('view_amenity')->with('success', 'Amenity deleted successfully.');
    }
}
