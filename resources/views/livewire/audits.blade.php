<div class="card">
    <div class="card-body">
        @script
            <script>
                $('#audits').DataTable({
                    columnDefs: [
                        {
                        targets: -1, // Last column
                        orderable: false,
                        searchable: false
                        }
                    ],
                    order: [],
                });
            </script>
        @endscript
        <div class="table-responsive">
            <table id="audits" class="table small">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">User Type</th>
                        <th scope="col">Audit Type</th>
                        <th scope="col">Act</th>
                        <th scope="col">Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($audits as $audit)
                        <tr class="">
                            <td>
                                @if (is_null($audit->user_id))
                                    <span class="fst-italic">System Generated.</span>
                                @else
                                    <a href="{{ route('accounts.show', $audit->user_id) }}" class="text-reset">
                                        {{ $audit->user_type::find($audit->user_id)->first_name .
                                            ' ' .
                                            $audit->user_type::find($audit->user_id)->last_name }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if (is_null($audit->user_id))
                                    <span class="fst-italic">System Generated.</span>
                                @else
                                    {{ ucfirst($audit->user_type::find($audit->user_id)->usertype) }}
                                @endif
                            </td>
                            <td>
                                @switch($audit->event)
                                    @case('created')
                                        <span class="text-success">Create</span>
                                    @break

                                    @case('updated')
                                        <span class="text-blackbean">Update</span>
                                    @break

                                    @case('deleted')
                                        <span class="text-danger">Delete</span>
                                    @break

                                    @case('restored')
                                        <span class="text-darkgreen">Restore</span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td>
                                @if (is_null($audit->user_id) && $audit->event == 'created' && $audit->auditable_type == 'App\Models\User')
                                    New account registered.
                                @else
                                    {{ $audit->user_type::find($audit->user_id)->first_name .
                                        ' ' .
                                        $audit->event .
                                        ' ' .
                                        last(explode('\\', $audit->auditable_type)) .
                                        ' (ID: ' .
                                        $audit->auditable_id .
                                        ')' }}
                                @endif
                            </td>
                            <td>
                                {{ date('M-j-Y', strtotime($audit->created_at)) . ' | ' . date('h:m a', strtotime($audit->created_at)) }}
                            </td>
                            <td class="align-middle text-center">
                                <a class="icon-link" data-bs-toggle="offcanvas" href="#auditDetails{{ $audit->id }}"
                                    role="button" aria-controls="auditDetails{{ $audit->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                    </svg>
                                </a>
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="auditDetails{{ $audit->id }}"
                                    aria-labelledby="auditDetails{{ $audit->id }}Label">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title" id="auditDetails{{ $audit->id }}Label">Audit
                                            Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body vstack text-start">
                                        <div>User:
                                            @if (is_null($audit->user_id) && $audit->event == 'created' && $audit->auditable_type == 'App\Models\User')
                                                <span class="fst-italic">System Generated.</span>
                                            @else
                                                <a href="{{ route('accounts.show', $audit->user_id) }}">
                                                    {{ $audit->user_type::find($audit->user_id)->first_name .
                                                        ' ' .
                                                        $audit->user_type::find($audit->user_id)->last_name }}
                                                </a> | <span
                                                    class="text-muted fst-italic">{{ ucfirst($audit->user_type::find($audit->user_id)->usertype) }}</span>
                                            @endif
                                        </div>
                                        @switch($audit->event)
                                            @case('created')
                                                <div>Action: <span class="fw-medium">Create</span></div>
                                                <div>{{ last(explode('\\', $audit->auditable_type)) . ' table details:' }}
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-light table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Properties</th>
                                                                <th scope="col">Values</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($audit->new_values as $key => $value)
                                                                <tr class="">
                                                                    <td scope="row">{{ $key }}</td>
                                                                    <td>{{ $value }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @break

                                            @case('updated')
                                                <div>Action: <span class="fw-medium">Update</span></div>
                                                <div>{{ last(explode('\\', $audit->auditable_type)) . ' table details:' }}
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-light table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Properties</th>
                                                                <th scope="col">Old Values</th>
                                                                <th scope="col">New Values</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($audit->getModified() as $key => $value)
                                                                <tr class="">
                                                                    <td scope="row">{{ $key }}</td>
                                                                    <td>{{ $value['old'] }}</td>
                                                                    <td>{{ $value['new'] }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @break

                                            @case('deleted')
                                                <div>Action: <span class="fw-medium">Delete</span></div>
                                                <div>{{ last(explode('\\', $audit->auditable_type)) . ' table details:' }}
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-light table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Properties</th>
                                                                <th scope="col">Values</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($audit->old_values as $key => $value)
                                                                <tr class="">
                                                                    <td scope="row">{{ $key }}</td>
                                                                    <td>{{ $value }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @break

                                            @case('restored')
                                                <div>Action: <span class="fw-medium">Restore</span></div>
                                                <div>{{ last(explode('\\', $audit->auditable_type)) . ' table details:' }}
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-light table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Properties</th>
                                                                <th scope="col">Values</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($audit->new_values as $key => $value)
                                                                <tr class="">
                                                                    <td scope="row">{{ $key }}</td>
                                                                    <td>{{ $value }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @break

                                            @default
                                        @endswitch
                                        <div class="table-responsive mt-3">
                                            <table class="table table-secondary table-bordered small">
                                                <tbody>
                                                    <tr class="">
                                                        <th>URL</th>
                                                        <td>{{ $audit->url }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th>IP Address</th>
                                                        <td>{{ $audit->ip_address }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th>User Agent</th>
                                                        <td>{{ $audit->user_agent }}</td>
                                                    </tr>
                                                    <tr class="">
                                                        <th>Tags</th>
                                                        <td>{{ $audit->tags }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mt-auto">
                                            <p class="mb-1">
                                                Date Created:
                                                {{ date('M j, Y', strtotime($audit->created_at)) . ' | ' . date('h:m a', strtotime($audit->created_at)) }}
                                            </p>
                                            <p class="mb-0">
                                                Date last updated:
                                                {{ date('M j, Y', strtotime($audit->updated_at)) . ' | ' . date('h:m a', strtotime($audit->updated_at)) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
