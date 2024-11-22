<div class="card">
    <div class="card-header fs-4 fw-semibold text-bg-danger">Deactivate Account</div>
    <div class="card-body">
        <div class="card-subtitle fst-italic">Once your account is deactivated, you will no longer have access to the system. To activate your account, contact us through <a href="tel:470-944-7433">470-944-7433</a> or though our email <a href="mailto:pensionneestella@gmail.com">pensionneestella@gmail.com</a></div>
        <div class="d-flex mt-2">
            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                Deactivate Account
            </button>
        </div>

        <div class="modal fade" id="deleteAccountModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 border-0">
                    <div class="modal-header text-bg-danger rounded-top-4">
                        <h5 class="modal-title" id="modalTitleId">
                            Are you sure?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="fw-medium mb-1">
                            <strong>Note</strong>: You cannot deactivate your account if there are pending, confirmed, or checked-in bookings. Please enter your password to confirm your action.
                        </div>
                        <form action="{{ route('profile.destroy') }}" method="post">
                            @csrf
                            @method('delete')

                            <div class="mb-3">
                                <label for="password" class="form-label mb-0">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required/>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-darkgreen">Confirm Action</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
