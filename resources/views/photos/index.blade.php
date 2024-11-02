@extends('layouts.manager')
@section('page', 'Photos')
@section('content')
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">Gallery</h4>
                        <a href="{{ route('photos.create') }}" class="btn btn-primary">Add Photo</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @push('scripts')
                                <script type="module">
                                    $(document).ready(function () {
                                        $('#photos').DataTable({
                                            scrollX: true,
                                            scrollY: "25rem",

                                        });
                                    });
                                </script>
                            @endpush
                            <table id="photos" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-nowrap">Tied to</th>
                                        <th class="text-center text-nowrap">Image</th>
                                        <th class="text-center text-nowrap">Description</th>
                                        <th class="text-center text-nowrap">File path</th>
                                        <th class="text-center text-nowrap">Date Added</th>
                                        <th class="text-center text-nowrap">Date Updated</th>
                                        <th class="text-center text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($photos as $index => $photo)
                                        <tr>
                                            <td class="text-center text-nowrap">{{ $photo->unit->name }}</td>
                                            <td class="text-center text-nowrap">
                                                <img src="{{ asset($photo->photos_path) }}"
                                                    class="img-fluid object-fit-cover" style="height: 10rem; width: 25rem;">
                                            </td>
                                            <td class="text-center">{{ $photo->descr }}</td>
                                            <td class="text-center">{{ $photo->photos_path }}</td>
                                            <td class="text-center">{{ date('M j, Y', strtotime($photo->created_at)) }}</td>
                                            <td class="text-center">{{ date('M j, Y', strtotime($photo->updated_at)) }}</td>
                                            <td>
                                                <a href="{{ route('photos.edit', $photo->id) }}"
                                                    class="btn btn-success">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
