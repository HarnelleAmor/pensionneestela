@extends('layouts.manager')
@section('page', 'Photos')
@section('content')
<div class="container my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white">PHOTO GALLERY</h5>
                    <a href="{{ route('photos.create') }}" class="btn btn-primary">Add Photo</a>
                </div>
                <div class="card-body">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($photos->isEmpty())
                    <div class="alert alert-warning text-center" role="alert">
                        No photos available in the gallery.
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Unit</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($photos as $index => $photo)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $photo->unit->name }}</td>
                                    <td>
                                        <img src="{{ asset($photo->photos_path) }}"
                                            style="width: 150px; height: auto;"
                                            alt="Photo {{ $photo->id }}">
                                    </td>
                                    <td>{{ $photo->descr }}</td>
                                    <td>
                                        <div class="d-flex align-items-center h-100">
                                            <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-success mx-2">Edit</a>
                                        <!-- Trigger the modal -->
                                        <button type="button" class="btn btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $photo->id }}">
                                            Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $photo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this photo?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $photos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
