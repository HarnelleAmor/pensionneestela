{{-- @extends('layouts.manager')

@section('content')
    @if ($errors->has('unit_name') || $errors->has('occupancy_limit') || $errors->has('bed_configuration') || $errors->has('view') || $errors->has('location') || $errors->has('price_per_night'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            There are errors in updating a unit. Please review the attempted change and correct the errors.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h2>EDIT UNITS
                            <a href="{{ url('units') }}" class="btn btn-primary float-end">Back</a>
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('units/' . $unit->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')  <!-- This indicates that the form is used for an update -->

                            <div class="mb-3">
                                <label>Unit Name</label>
                                <input type="text" name="unit_name" class="form-control" value="{{ old('unit_name', $unit->unit_name) }}">
                                @error('unit_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Availability</label>
                                <select name="availability" class="form-control">
                                    <option value="1" {{ old('availability', $unit->availability) == 1 ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ old('availability', $unit->availability) == 0 ? 'selected' : '' }}>Not Available</option>
                                </select>
                                @error('availability') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Size</label>
                                <input type="text" name="size" class="form-control" value="{{ old('size', $unit->size) }}">
                                @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Occupancy Limit</label>
                                <input type="number" name="occupancy_limit" class="form-control" value="{{ old('occupancy_limit', $unit->occupancy_limit) }}">
                                @error('occupancy_limit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Bed Configuration</label>
                                <input type="text" name="bed_configuration" class="form-control" value="{{ old('bed_configuration', $unit->bed_configuration) }}">
                                @error('bed_configuration') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>


                            <div class="mb-3">
                                <label>View</label>
                                <input type="text" name="view" class="form-control" value="{{ old('view', $unit->view) }}">
                                @error('view') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $unit->location) }}">
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Price Per Night</label>
                                <input type="text" name="price_per_night" class="form-control" value="{{ old('price_per_night', $unit->price_per_night) }}">
                                @error('price_per_night') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- <div class="mb-3">
                                <label>Upload File/Image</label>
                                <input type="file" name="image" class="form-control">
                                @if ($unit->image)
                                    <div class="mt-2">
                                        <label>Current Image:</label>
                                        <img src="{{ asset($unit->image) }}" alt="Current Image" style="width: 300px; height: 200px;">
                                    </div>
                                @endif
                            </div> -->

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">UPDATE</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
 --}}


@extends('layouts.manager')
@section('page', 'Unit Edit')
@section('content')
    <div class="container py-4 px-5">
        <div class="row justify-content-between align-items-center mb-2">
            <div class="col-auto">
                <div class="fs-2 fw-medium">{{ $unit->name }}</div>
            </div>
            <div class="col-auto align-self-end align-items-center d-lg-flex d-md-flex gap-2 text-end">
                <a href="{{ route('units.index') }}" class="btn btn-light px-4">
                    Close
                </a>
                <button class="btn btn-success px-4">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </div>
        </div>

        <div class="card rounded-0 border-0 shadow">
            <div class="card-body px-4 py-5">
                <div class="row g-2">
                    <div class="col-lg-12">
                        <div class="fs-5 fw-semibold">Unit Pictures</div>
                        <!-- Image Gallery -->
                        <div class="d-flex flex-row overflow-x-auto gap-2">
                            @foreach ($unit->photos as $photo)
                                <img src="{{ asset($photo->photos_path) }}" alt="Photo"
                                    class="img-fluid object-fit-cover rounded-3" style="height: 125px; width: 200px;"
                                    data-bs-toggle="modal" data-bs-target="#photoModal"
                                    data-photo-url="{{ asset($photo->photos_path) }}" data-photo-id="{{ $photo->id }}">
                            @endforeach
                        </div>

                        <!-- Modal for Full View (single modal for all photos) -->
                        <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="photoModalLabel">Photo Preview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="modalPhoto" src="" class="img-fluid w-100" alt="Full View">
                                    </div>
                                    <div class="modal-footer">
                                        <form id="deletePhotoForm" action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Photo</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                            <script type="module">
                                document.addEventListener('DOMContentLoaded', function() {
                                    const modal = document.getElementById('photoModal');
                                    const modalPhoto = document.getElementById('modalPhoto');
                                    const deleteForm = document.getElementById('deletePhotoForm');

                                    // Event listener for all images
                                    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(img => {
                                        img.addEventListener('click', function() {
                                            const photoUrl = this.getAttribute('data-photo-url');
                                            const photoId = this.getAttribute('data-photo-id');

                                            // Set the modal image source
                                            modalPhoto.src = photoUrl;

                                            // Update the form action for deleting the photo
                                            deleteForm.action = `/photos/${photoId}`;
                                        });
                                    });
                                });
                            </script>
                        @endpush



                    </div>
                    <div class="col-lg-12">
                        <div class="fs-5 fw-semibold">Unit Details</div>
                        <div class="row justify-content-center align-items-start g-2">
                            <div class="col-md-3">
                                <label for="name" class="form-label mb-0">Unit Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ $unit->name }}" readonly />
                            </div>
                            <div class="col-md-3">
                                <label for="capacity" class="form-label mb-0">Guest Capacity</label>
                                <input type="number" class="form-control" id="capacity"
                                    value="{{ $unit->occupancy_limit }}" readonly />
                            </div>
                            <div class="col-md-3">
                                <label for="location" class="form-label mb-0">Unit Floor</label>
                                <input type="text" class="form-control" id="location" value="{{ $unit->location }}"
                                    readonly />
                            </div>
                            <div class="col-md-3">
                                <label for="price_per_night" class="form-label mb-0">Unit Price (<span
                                        class="fst-italic text-muted">per night</span>)</label>
                                <input type="number" class="form-control" name="price_per_night" id="price_per_night"
                                    value="{{ old('price_per_night', $unit->price_per_night) }}" required />
                            </div>
                            <div class="col-md-3">
                                <label for="bed_configuration" class="form-label mb-0">Bed Configuration</label>
                                <input type="text" class="form-control" name="bed_configuration" id="bed_configuration"
                                    value="{{ old('bed_configuration', $unit->bed_config) }}" required />
                            </div>
                            <div class="col-md-3">
                                <label for="view" class="form-label mb-0">Unit View</label>
                                <input type="text" class="form-control" name="view" id="view"
                                    value="{{ old('view', $unit->view) }}" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="fs-5 fw-semibold">Unit Amenities</div>
                        <div class="row g-2">
                            @foreach ($amenities as $amenity)
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="amenity{{$amenity->id}}" @checked($amenity->is_checked)/>
                                        <label class="form-check-label" for="amenity{{$amenity->id}}">
                                            {{$amenity->name}}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Unit Image Upload Section -->
                    {{-- <div class="col-lg-7">
                        <img src="https://via.placeholder.com/600x400" class="img-fluid mb-3" alt="Unit Image">
                        <div class="d-flex">
                            <img src="https://via.placeholder.com/100x100" class="img-thumbnail me-2" alt="Thumbnail">
                            <img src="https://via.placeholder.com/100x100" class="img-thumbnail me-2" alt="Thumbnail">
                            <img src="https://via.placeholder.com/100x100" class="img-thumbnail me-2" alt="Thumbnail">
                        </div>
                        <button class="btn btn-light mt-3 w-100">
                            <i class="bi bi-upload"></i> Upload New Photos
                        </button>
                    </div> --}}

                    <!-- Unit Details Section -->
                    {{-- <div class="col-lg-5">
                        <form>
                            <div class="mb-3">
                                <label for="unitPrice" class="form-label">Unit Price (Per Night)</label>
                                <input type="number" class="form-control" id="unitPrice" value="2500">
                            </div>

                            <div class="mb-3">
                                <label for="unitCapacity" class="form-label">Capacity</label>
                                <input type="text" class="form-control" id="unitCapacity" value="6 guests">
                            </div>

                            <div class="mb-3">
                                <label for="unitLocation" class="form-label">Location</label>
                                <input type="text" class="form-control" id="unitLocation" value="Balcony View">
                            </div>

                            <!-- Editable Unit Amenities Section -->
                            <h5>Unit Amenities</h5>
                            <div class="d-flex flex-wrap mb-3">
                                <div class="form-check form-check-inline me-2 mb-2">
                                    <input class="form-check-input" type="checkbox" id="amenityWifi" checked>
                                    <label class="form-check-label badge bg-success text-white" for="amenityWifi">
                                        <i class="bi bi-wifi"></i> Free Wifi
                                    </label>
                                </div>
                                <div class="form-check form-check-inline me-2 mb-2">
                                    <input class="form-check-input" type="checkbox" id="amenityTV">
                                    <label class="form-check-label badge bg-light text-dark" for="amenityTV">
                                        <i class="bi bi-tv"></i> Cable TV
                                    </label>
                                </div>
                                <div class="form-check form-check-inline me-2 mb-2">
                                    <input class="form-check-input" type="checkbox" id="amenityShower">
                                    <label class="form-check-label badge bg-light text-dark" for="amenityShower">
                                        <i class="bi bi-bucket"></i> Shower
                                    </label>
                                </div>

                                <!-- Add new amenity input -->
                                <div class="input-group mt-3 w-100">
                                    <button class="btn btn-outline-success" type="button" id="addAmenityButton">
                                        <i class="bi bi-plus-circle"></i> Add Unit Amenity
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
