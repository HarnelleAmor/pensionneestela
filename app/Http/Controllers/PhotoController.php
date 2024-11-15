<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('is-manager');
        // Retrieve photos ordered by the latest created first
        $photos = Photo::with('unit')->orderBy('created_at', 'desc')->get();
        return view('photos.index', compact('photos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('is-manager');
        // Fetch all units ordered by the most recently created
        $units = Unit::orderBy('created_at', 'desc')->get();
        return view('photos.create', compact('units'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('is-manager');

        // Validate the incoming request
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'photos_path' => 'required|image|mimes:jpeg,png,jpg,gif', // Change max to 5000 KB (5 MB)
            'descr' => 'required|string|max:255',
        ]);

        $data = new Photo();

        // Handle the file upload
        if ($request->hasFile('photos_path')) {
            $image = $request->file('photos_path');

            // Change the image name
            $imagename = time() . '.' . $image->getClientOriginalExtension();

            // Store image in the public folder (photos)
            $image->move(public_path('assets/images'), $imagename);

            // Store image path in the database
            $data->photos_path = 'assets/images/' . $imagename;
        }

        // Assign other fields
        $data->unit_id = $request->unit_id;
        $data->descr = $request->descr;

        // Save the data to the database
        $data->save();

        Alert::success('Success', 'Photo added successfully!');
        return redirect()->back();
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

        Alert::success('Success', 'Photo updated successfully.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('is-manager');
        $photo = Photo::findOrFail($id);

        // Attempt to delete the photo
        if ($photo->delete()) {
            Alert::success('Success', 'Photo successfully deleted.');
        } else {
            Alert::error('Error', 'There was an error deleting the photo.');
        }

        // Redirect to the photos index page
        return redirect()->back();
    }
}
