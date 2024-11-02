@extends('layouts.manager')

@section('content')

<div class="container">
    <h1>Create Photo</h1>

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

    {{-- Form for creating a new photo --}}
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf 

        <!-- Unit ID -->
        <div class="mb-3">
            <label for="unit_id" class="form-label">Unit</label>
            <select name="unit_id" id="unit_id" class="form-select @error('unit_id') is-invalid @enderror" required>
                <option value="">-- Select Unit --</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                @endforeach
            </select>
            @error('unit_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Photo Upload -->
        <div class="mb-3">
            <label for="photos_path" class="form-label">Upload Photo</label>
            <input type="file" name="photos_path" id="photos_path" class="form-control @error('photos_path') is-invalid @enderror" accept="image/*" required>
            @error('photos_path')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="descr" class="form-label">Description</label>
            <textarea name="descr" id="descr" class="form-control @error('descr') is-invalid @enderror" rows="3" required>{{ old('descr') }}</textarea>
            @error('descr')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Photo</button>
        <a href="{{ route('photos.index') }}" class="btn btn-secondary">Back to Photos</a>
    </form>
</div>
@endsection
