@extends('layouts.manager')
@section('page', 'Backup & Restore')
@section('content')
    <div class="container my-3">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card border-0 rounded-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <form action="{{ route('backuprestore.now') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-blackbean">
                                    Backup Now
                                </button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-light table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2" class="text-center">System Backup (Files & Database Tables)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="col">Name of Backup File</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    @foreach ($files as $file)
                                        <tr class="">
                                            <td>{{ basename($file) }}</td>
                                            <td>
                                                <form action="{{ route('backuprestore.download') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="backup_file" value="{{ basename($file) }}">
                                                    <button type="submit" class="btn btn-darkgreen">
                                                        Download
                                                    </button>
                                                </form>
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
        <div class="col-lg-4">
            
        </div>
    </div>
@endsection
