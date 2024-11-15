@extends('layouts.manager')

@section('content')
    <div class="container pt-3 vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Upload Photo</h5>
                        <a href="{{ route('photos.index') }}" class="btn btn-primary">Back to Photos</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="image" class="form-label mb-0">Upload Image</label>
                                <input type="file" name="photos_path" class="form-control" id="image" value="{{ old('photos_path') }}" required>
                                @error('photos_path') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="unit_id" class="form-label mb-0">Select Unit</label>
                                <select name="unit_id" class="form-select" id="unit_id" required>
                                    <option selected disabled>-- Select Unit --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" @selected( $unit->id == old('unit_id'))>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="description" class="form-label mb-0">Description</label>
                                <textarea name="descr" class="form-control" id="description" rows="1" required>{{ old('descr') }}</textarea>
                                @error('descr') 
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-darkgreen px-4">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection