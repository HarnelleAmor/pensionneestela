@extends('layouts.manager')

@section('content')

<!-- Total Number of Amenities -->
<div class="col-md-12 d-flex justify-content-center mb-3">
    <p>Total Number of Amenities: {{ $totalAmenities }}</p>
</div>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Manage Amenities</h5>
            <div>
                <a href="{{ route('amenities.create') }}" class="btn btn-primary">Add Amenity</a>
            </div>
        </div>
        <!-- Amenities Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">Amenity Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $amenity)
                    <tr>
                        <td>{{ $amenity->name }}</td>
                        <td>{{ $amenity->category }}</td>
                        <td><img width="50" src="{{ asset('icons/' . $amenity->icon) }}" alt="Amenity Icon"></td>
                        <td class="d-flex">
                            <form action="{{ route('amenities.destroy', ['amenity' => $amenity->id]) }}" method="POST" class="me-2">
                                @method('DELETE')
                                @csrf
                                <input type="hidden" name="amenity_id" value="{{ $amenity->id }}">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this amenity? This action cannot be undone.');">Delete</button>
                            </form>

                            <form action="{{ route('amenities.edit', ['amenity' => $amenity->id]) }}" method="GET">
                                @csrf
                                <input type="hidden" name="amenity_id" value="{{ $amenity->id }}">
                                <button class="btn btn-warning" type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-5">
    {{ $data->links() }}
</div>
@endsection