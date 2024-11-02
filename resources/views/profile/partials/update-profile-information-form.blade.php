<div class="card">
    <div class="card-header fs-4 fw-semibold text-bg-primary">Profile Information</div>
    <div class="card-body">
        <div class="card-subtitle fst-italic">Update your account's profile information.</div>
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
        <form action="{{ route('profile.update') }}" method="post">
            @csrf
            @method('PATCH')
            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label mb-0">First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                        value="{{ old('first_name', $user->first_name) }}" required/>
                    @error('first_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label mb-0">Last Name</label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                        value="{{ old('last_name', $user->last_name) }}" required/>
                    @error('last_name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label mb-0">Email</label>
                    <input type="email" class="form-control" name="email" id="email"
                        value="{{ old('email', $user->email) }}" required/>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone_no" class="form-label mb-0">Phone Number</label>
                    <input type="text" pattern="\d*" minlength="11" class="form-control" name="phone_no" id="phone_no"
                        placeholder="09•••••••••" value="{{ old('phone_no', $user->phone_no) }}" />
                    @error('phone_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="col-12 mb-3">
                        <div>
                            <p class="text-body-secondary fst-italic">
                                Your email address is unverified.
                                <button form="send-verification" class="btn btn-primary">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>
    
                            @if (session('status') === 'verification-link-sent')
                                <p class="fw-medium text-body-success">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    @if (session('status') === 'profile-updated')
                        <script type="module">
                            Swal.fire({
                                icon: 'success',
                                title: 'Profile Updated!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        </script>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
