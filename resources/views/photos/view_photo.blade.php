@extends('layouts.manager')

@section('content')

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Manage Photos</h5>
                <div>
                    <a href="{{ route('photos.create') }}" class="btn btn-primary">Add Photo</a>
                </div>
            </div>

            <!-- Photos Table -->
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Unit</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Description</th>
                            <th scope="col">Archived</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($photos as $photo)
                        <tr>
                            <td>{{ $photo->unit->name }}</td>
                            <td>
                                <img width="100" src="{{ asset($photo->photos_path) }}" alt="Photo" class="img-thumbnail">
                            </td>
                            <td>{{ $photo->descr }}</td>
                            <td>{{ $photo->is_archived ? 'Yes' : 'No' }}</td>
                            <td class="d-flex">
                                <!-- Delete Button -->
                                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" class="me-2">
                                    @csrf
                                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this photo? This action cannot be undone.');">Delete</button>
                                </form>

                                
                                <a href="{{route('photos.edit', $photo->id)}}" class="btn btn-warning">Update</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection