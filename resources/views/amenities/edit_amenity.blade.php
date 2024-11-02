@extends('layouts.manager')

@section('content')

<div class="container-fluid">
    <!-- Display success or error messages -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Edit Amenity Form -->
    <div class="col-md-6 offset-md-3">
        <h2 class="text-center mb-4">Edit Amenity</h2>

        <form action="{{ route('amenities.update', ['amenity' => $amenity->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <!-- Hidden input to pass amenity ID -->
            <input type="hidden" name="amenity_id" value="{{ $amenity->id }}">

            <!-- Amenity Name -->
            <div class="form-group mb-3">
                <label for="name">Amenity Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $amenity->name }}" required>
            </div>

            <!-- Category -->
            <div class="form-group mb-3">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="bedroom" {{ $amenity->category == 'bedroom' ? 'selected' : '' }}>Bedroom</option>
                    <option value="bathroom" {{ $amenity->category == 'bathroom' ? 'selected' : '' }}>Bathroom</option>
                    <option value="kitchen" {{ $amenity->category == 'kitchen' ? 'selected' : '' }}>Kitchen</option>
                    <option value="comforts" {{ $amenity->category == 'comforts' ? 'selected' : '' }}>Comforts</option>
                </select>
            </div>

            <!-- Icon (Optional) -->
            <div class="form-group mb-3">
                <label for="icon">Amenity Icon (Optional)</label>
                <input type="file" class="form-control" id="icon" name="icon">
                <small>Current icon: <img width="50" src="{{ asset('icons/' . $amenity->icon) }}" alt="Amenity Icon"></small>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn btn-warning w-100">Update Amenity</button>
            </div>
        </form>

        <!-- Back Button -->
        <div class="mt-3 text-center">
            <a href="{{ route('view_amenity') }}" class="btn btn-secondary">Back to Amenity List</a>
        </div>
    </div>
</div>

@endsection