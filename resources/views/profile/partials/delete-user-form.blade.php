<div class="card">
    <div class="card-header fs-4 fw-semibold text-bg-danger">Delete Account</div>
    <div class="card-body">
        <div class="card-subtitle fst-italic">Once your account is deleted, all of its resources and data will
            be
            permanently deleted. Before deleting your account, please download any data or information that you wish to
            retain.</div>
        <div class="d-flex mt-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                Delete Account
            </button>
        </div>

        <div class="modal fade" id="deleteAccountModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-bg-danger">
                        <h5 class="modal-title" id="modalTitleId">
                            Are you sure you want to delete your account?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fw-medium mb-1">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                            Please
                            enter your password to confirm you would like to permanently delete your account.
                        </div>
                        <form action="{{ route('profile.destroy') }}" method="post">
                            @csrf
                            @method('delete')

                            <div class="mb-3">
                                <label for="password" class="form-label mb-0">Password</label>
                                <input id="password" type="password" class="form-control" name="password" />
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
