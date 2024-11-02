@extends('layouts.manager')

@section('content')

<div class="container">
    <h1>Create Amenity</h1>

    {{-- Display success message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Display error message --}}
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    {{-- Form for creating a new amenity --}}
    <form action="{{ route('amenities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Amenity Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                <option value="">Select a category</option>
                <option value="bedroom" {{ old('category') == 'bedroom' ? 'selected' : '' }}>Bedroom</option>
                <option value="bathroom" {{ old('category') == 'bathroom' ? 'selected' : '' }}>Bathroom</option>
                <option value="kitchen" {{ old('category') == 'kitchen' ? 'selected' : '' }}>Kitchen</option>
                <option value="comforts" {{ old('category') == 'comforts' ? 'selected' : '' }}>Comforts</option>
            </select>
            @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="icon" class="form-label">Icon (Image Upload)</label>
            <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*" required>
            @error('icon')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Amenity</button>
        <a href="{{ route('amenities.index') }}" class="btn btn-secondary">Back to Amenities</a>
    </form>
</div>

@endsection