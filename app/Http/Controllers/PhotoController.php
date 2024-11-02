<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        $photos = Photo::with('unit')->paginate(4); 
        return view('photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        $units = Unit::all(); // Fetch all units
        return view('photos.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');
        $request->validate([
            'unit_id' => 'required|exists:units,id', 
            'photos_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'descr' => 'required|string|max:255',
        ]);

        $data = new Photo();

        if ($request->hasFile('photos_path')) {
            $image = $request->file('photos_path');

            // Change the image name
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            // Store image in the public folder (photos)
            $image->move(public_path('assets/images'), $imagename);

            // Store image name in the database table
            $data->photos_path = 'assets/images/' . $imagename;
        }

        $data->unit_id = $request->unit_id;
        $data->descr = $request->descr;

        // Save the data to the database
        $data->save();

        return redirect()->route('photos.index')->with('success', 'Photo added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Gate::authorize('is-manager');
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('is-manager');
        $photo = Photo::findOrFail($id);
        $units = Unit::all();
        return view('photos.edit', compact('photo', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('is-manager');
        $photo = Photo::findOrFail($id);
        $photo->update($request->only(['unit_id', 'descr', 'is_archived']));

        if ($request->hasFile('photos_path')) {
            $path = $request->file('photos_path')->store('assets/images', 'public');
            $photo->update(['photos_path' => $path]);
        }

        return redirect()->route('photos.index')->with('success', 'Photo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('is-manager');
        $photo = Photo::findOrFail($id);
        $photo->delete();

        return redirect()->route('photos.index')->with('success', 'Photo deleted successfully.');
    }
}
