@extends('layouts.manager')

@section('content')

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Photo</h4>
                    </div>

                    <div class="card-body">
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

                        <!-- Form to edit the photo -->
                        <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Unit ID -->
                            <div class="form-group mb-3">
                                <label for="unit_id">Unit</label>
                                <select name="unit_id" id="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $unit->id == $photo->unit_id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="form-group mb-3">
                                <label for="photos_path">Upload New Photo</label>
                                <input type="file" name="photos_path" id="photos_path" class="form-control @error('photos_path') is-invalid @enderror">
                                <small>Leave blank if you don't want to change the photo.</small>
                                @error('photos_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group mb-3">
                                <label for="descr">Description</label>
                                <textarea name="descr" id="descr" class="form-control @error('descr') is-invalid @enderror" rows="3" required>{{ $photo->descr }}</textarea>
                                @error('descr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Archive Status -->
                            <div class="form-group mb-3">
                                <label for="is_archived">Archive Status</label>
                                <select name="is_archived" id="is_archived" class="form-control @error('is_archived') is-invalid @enderror" required>
                                    <option value="0" {{ $photo->is_archived == 0 ? 'selected' : '' }}>Active</option>
                                    <option value="1" {{ $photo->is_archived == 1 ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('is_archived')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100">Update Photo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection