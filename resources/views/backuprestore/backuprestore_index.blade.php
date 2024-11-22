@extends('layouts.manager')
@section('page', 'Backup & Restore')
@section('content')
    <div class="container my-3">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <div class="card rounded-4">
                    <div class="card-body">
                        @error('backup_file')
                            <div class="d-flex">
                                <div class="alert alert-warning d-inline-flex mx-auto" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $message }}
                                </div>
                            </div>
                        @enderror
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="backup-tab" data-bs-toggle="tab"
                                    data-bs-target="#backup-tab-pane" type="button" role="tab"
                                    aria-controls="backup-tab-pane" aria-selected="true">Backup</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="restore-tab" data-bs-toggle="tab"
                                    data-bs-target="#restore-tab-pane" type="button" role="tab"
                                    aria-controls="restore-tab-pane" aria-selected="false">Restore</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="backup-tab-pane" role="tabpanel"
                                aria-labelledby="backup-tab" tabindex="0">
                                <div class="row justify-content-center align-items-start g-2 py-3">
                                    <div class="col-md-10">
                                        <div class="alert alert-info" role="alert">
                                            <div class="">
                                                <strong>Info</strong>: Backups are automatically done everyday at midnight.
                                                <a class="small" role="button" data-bs-toggle="modal"
                                                    data-bs-target="#backupDetails">Cleanup details</a>
                                            </div>
                                            <div class="modal fade" id="backupDetails" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                aria-labelledby="backupdDetailsTitleId" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content rounded-4 text-darkgreen">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="backupdDetailsTitleId">
                                                                Database Backup Cleanup Details
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul>
                                                                <li>Every backup created during the first week will be
                                                                    saved.
                                                                </li>
                                                                <li>After the first week, only the most recent backup from
                                                                    each
                                                                    day will be saved for the next 16 days.</li>
                                                                <li>After the daily backups, only the most recent backup
                                                                    from
                                                                    each week will be saved for the next 8 weeks.</li>
                                                                <li>After the weekly backups, only the most recent backup
                                                                    from
                                                                    each month will be saved for the next 4 months.</li>
                                                                <li>After the monthly backups, only the most recent backup
                                                                    from
                                                                    each year will be saved for the next 2 years.</li>
                                                                <li>If the total size of backups exceeds 5000 MB, the oldest
                                                                    backups will be deleted to free up space.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-light table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">
                                                            Automatic Backups
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Name of Backup</th>
                                                        <th scope="col">Date Created</th>
                                                        <th scope="col" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($files as $file)
                                                        <tr class="">
                                                            <td>{{ $file['name'] }}</td>
                                                            <td>{{ $file['created_at'] }}</td>
                                                            <td class="text-center">
                                                                <form action="{{ route('download.backup') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="backup_file"
                                                                        value="{{ $file['name'] }}">
                                                                    <button type="submit" class="btn btn-darkgreen btn-sm">
                                                                        <i class="bi bi-download me-2"></i>Export
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
                            <div class="tab-pane fade" id="restore-tab-pane" role="tabpanel" aria-labelledby="restore-tab"
                                tabindex="0">
                                <div class="row justify-content-center align-items-center g-2 py-3">
                                    <div class="col-md-8">
                                        <div class="alert alert-info" role="alert">
                                            <span class="fw-medium">Info</span>: You can only import the
                                            <strong>sql</strong> file of any backup files.
                                        </div>
                                        <div class="card rounded-4 shadow border-darkgreen">
                                            <div class="card-body text-darkgreen">
                                                <h4 class="card-title">Restore Database</h4>
                                                <p>Performing a database restore will initiate a database overwrite
                                                    operation, where the existing database is reset, and its contents are
                                                    replaced with the data from the provided file. Any existing data not
                                                    included in the file will be permanently deleted.
                                                </p>
                                                <form id="restoreDb" action="{{ route('restore.backup') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="hstack gap-3" x-data="{ fileSelected: false }">
                                                        <input class="form-control me-auto" type="file" name="backup_file" accept=".sql" required
                                                            x-on:change="fileSelected = $event.target.files.length > 0">
                                                        <button type="button" class="btn btn-darkgreen d-flex" data-bs-toggle="modal" data-bs-target="#restoreConfirm"
                                                            x-bind:disabled="!fileSelected">
                                                            <i class="bi bi-upload me-2"></i>Import
                                                        </button>
                                                    </div>
                                                    @error('backup_file')
                                                        <small class="text-danger fw-medium">{{ $message }}</small>
                                                    @enderror
                                                </form>
                                                <div class="modal fade" id="restoreConfirm" tabindex="-1"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                    aria-labelledby="restoreModalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content rounded-4">
                                                            <div class="modal-header border-bottom-0">
                                                                <h5 class="modal-title" id="restoreModalTitleId">
                                                                    Database Overwrite
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>After the restoring the database to it's desired state, you will be logged-out of the system.</p>
                                                            </div>
                                                            <div class="modal-footer border-top-0">
                                                                <button type="button" class="btn btn-darkgreen rounded-4"
                                                                x-data
                                                                x-on:click="$('#restoreDb').submit()"
                                                                >Got it! Proceed</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
