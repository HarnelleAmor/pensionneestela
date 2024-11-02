@extends('layouts.manager')

@section('content')
    <div class="container pt-3 vh-100">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('photos.index') }}" class="text-decoration-none">Back to Photos</a>
                            <button type="button" class="btn btn-danger btn-sm" x-data="{
                                alertConfirm() {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'You won\'t be able to revert this! This will delete the photo from the system.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#deletePic{{ $photo->id }}').submit();
                                        }
                                    });
                                }
                            }" x-on:click="alertConfirm()">
                                Delete this photo
                            </button>
                            <form id="deletePic{{ $photo->id }}" action="{{ route('photos.destroy', $photo->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>

                        <div class="row justify-content-center align-items-start g-2 mt-3">
                            <div class="col-lg-6 col-md-5">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset($photo->photos_path) }}" class="img-fluid object-fit-cover rounded-3">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-7">
                                <form action="{{ route('photos.update', $photo->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row align-items-center g-2 mb-2">
                                        <label for="unit_id" class="col-auto form-label mb-0">Tie image to:</label>
                                        <div class="col-auto">
                                            <select name="unit_id" class="form-control" id="unit_id" required>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ $unit->id == old('unit_id', $photo->unit_id) ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('unit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <label for="descr" class="col-auto form-label mb-0">Description:</label>
                                        <div class="col-auto">
                                            <textarea name="descr" id="descr" class="form-control @error('descr') is-invalid @enderror w-100" rows="1"
                                                required>{{ $photo->descr }}</textarea>
                                        </div>
                                        @error('descr')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_archived" id="active"
                                            @checked(!$photo->is_archived)>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="is_archived" id="archive"
                                            @checked($photo->is_archived)>
                                        <label class="form-check-label" for="archive">
                                            Archive
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-darkgreen px-3">Update Photo</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
