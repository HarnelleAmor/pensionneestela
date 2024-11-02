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
                            value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    <div class="col">
                        <label for="last_name" class="form-label mb-0 fw-medium ">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control bg-sage rounded-0 border-0 border-bottom border-2 border-blackbean pb-0 @error('name') is-invalid @enderror"
                            name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name"
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
                        name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
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
                    <button type="submit" class="btn btn-primary w-100 btn-blackbean">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
