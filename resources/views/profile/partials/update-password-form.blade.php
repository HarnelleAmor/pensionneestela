<div class="card">
    <div class="card-header fs-4 fw-semibold text-bg-info">Update Password</div>
    <div class="card-body">
        <div class="card-subtitle fst-italic">Ensure your account is using a long, random password to stay
            secure.
        </div>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label mb-0">Current Password</label>
                <input type="password" class="form-control" name="current_password" id="current_password"
                    autocomplete="current-password" />
                @error('current_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password" class="form-label mb-0">New Password</label>
                <input type="password" class="form-control" name="password" id="update_password_password"
                    autocomplete="new-password" />
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label mb-0">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation"
                    id="update_password_password_confirmation" autocomplete="new-password"
                    autocomplete="new-password" />
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-body-success">{{ __('Saved.') }}</p>
            @endif
        </form>
    </div>
</div>
