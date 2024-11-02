

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h2>ADD UNITS
                            <a href="{{ url('units') }}" class="btn btn-primary float-end">Back</a>
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('units') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label>Unit Name</label>
                                <input type="text" name="unit_name" class="form-control" value="{{ old('unit_name') }}">
                                @error('unit_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Availability</label>
                                <select name="availability" class="form-control">
                                    <option value="1" {{ old('availability') == 1 ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ old('availability') == 0 ? 'selected' : '' }}>Not Available</option>
                                </select>
                                @error('availability') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Size</label>
                                <input type="text" name="size" class="form-control" value="{{ old('size') }}">
                                @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Occupancy Limit</label>
                                <input type="number" name="occupancy_limit" class="form-control" value="{{ old('occupancy_limit') }}">
                                @error('occupancy_limit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Bed Configuration</label>
                                <input type="text" name="bed_configuration" class="form-control" value="{{ old('bed_configuration') }}">
                                @error('bed_configuration') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>



                            <div class="mb-3">
                                <label>View</label>
                                <input type="text" name="view" class="form-control" value="{{ old('view') }}">
                                @error('view') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Price Per Night</label>
                                <input type="text" name="price_per_night" class="form-control" value="{{ old('price_per_night') }}">
                                @error('price_per_night') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- <div class="mb-3">
                                <label>Upload File/Image</label>
                                <input type="file" name="image" class="form-control">
                                @if (old('image'))
                                    <div class="mt-2">
                                        <label>Preview:</label>
                                        <img src="{{ asset('storage/' . old('image')) }}" alt="Preview" style="width: 300px; height: 200px;">
                                    </div>
                                @endif
                            </div> -->

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

