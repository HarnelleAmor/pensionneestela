@extends('layouts.manager')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Upload Photo</h5>
                        <a href="{{ route('photos.index') }}" class="btn btn-primary">Back to Photos</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="unit_id" class="form-label">Select Unit ID</label>
                                <select name="unit_id" class="form-select" id="unit_id" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->id }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Image</label>
                                <input type="file" name="photos_path" class="form-control" id="image" required>
                                @error('photos_path') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="descr" class="form-control" id="description" rows="3" required></textarea>
                                @error('descr') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
