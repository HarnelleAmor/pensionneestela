@extends('layouts.logreg')

@section('content')
    <div class="card rounded-4 border-0 col-lg-4 col-md-6 col-sm-8 mx-auto shadow-lg text-bg-sage">
        <div class="card-body px-5">
            <h4 class="text-center fw-semibold mt-2">Sign Up</h4>

            @if (session('status'))
                <div class="mb-4 text-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="text-center small text-muted mb-2">
                <span>{{ __('Already registered?') }}</span>
                <a class="text-blackbean" href="{{ route('login') }}"
                    class="text-register"><span>{{ __('Log in here') }}</span></a>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="first_name" class="form-label mb-0 fw-medium ">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('first_name') is-invalid @enderror" name="first_name"
                            value="{{ old('first_name') }}" placeholder="(e.g. Juan)" required autocomplete="first_name" autofocus>
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    <div class="col">
                        <label for="last_name" class="form-label mb-0 fw-medium ">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}" placeholder="(e.g Dela Cruz)" required autocomplete="last_name"
                            autofocus>
    
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label mb-0 fw-medium ">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_no" class="form-label mb-0 fw-medium ">{{ __('Phone Number') }}</label>
                    <input id="phone_no" type="number" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('phone_no') is-invalid @enderror"
                        name="phone_no" value="{{ old('phone_no') }}" min="0" placeholder="09XX-XXX-YYYY" required autocomplete="phone_no">
                    @error('phone_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label mb-0 fw-medium ">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('password') is-invalid @enderror" name="password" required
                        autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password-confirm" class="form-label mb-0 fw-medium ">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0" name="password_confirmation"
                        required autocomplete="new-password">
                </div>

                <div class="mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="termsConditions" name="terms_conditions" required>
                        <label class="form-check-label small" for="termsConditions">
                          I agree to the <a href="{{ route('privacy-policy') }}">Privacy Policy</a> and <a href="{{ route('terms-conditions') }}">Terms & Conditions</a>
                        </label>
                    </div>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary w-100 btn-blackbean">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
