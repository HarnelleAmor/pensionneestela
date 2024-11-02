@extends('layouts.manager')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">UPDATE PHOTO</h5>
                        <a href="{{ route('photos.index') }}" class="btn btn-primary">Back to Photos</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="unit_id">Select Unit</label>
                                <select name="unit_id" class="form-control" id="unit_id" required>
                                    <option value="">-- Select Unit --</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $unit->id == old('unit_id', $photo->unit_id) ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('unit_id') 
                                    <span class="text-danger">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Photo Upload -->
                            <div class="form-group mb-3">
                                <label for="photos_path">Update Photo</label>
                                <input type="file" name="photos_path" id="photos_path" class="form-control @error('photos_path') is-invalid @enderror">
                                <small>Leave blank if you don't want to change the photo.</small>
                                @error('photos_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="descr">Description</label>
                                <textarea name="descr" id="descr" class="form-control @error('descr') is-invalid @enderror" rows="3" required>{{ $photo->descr }}</textarea>
                                @error('descr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <button type="submit" class="btn btn-primary">Update Photo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
