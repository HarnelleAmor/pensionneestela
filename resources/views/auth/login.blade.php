@extends('layouts.logreg')
@section('content')
    <div class="card rounded-4 border-0 col-lg-4 col-md-6 col-sm-8 mx-auto shadow-lg text-bg-sage">
        <div class="card-body px-5">
            <h4 class="text-center fw-semibold mt-2 text-darkgreen">Log In</h4>

            @if (session('status'))
                <div class="alert alert-info mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label mb-0 fw-medium text-darkgreen">{{ __('Email') }}</label>
                    <input id="email" type="email"
                        class="form-control text-darkgreen bg-sage rounded-0 border-0 border-bottom border-2 border-darkgreen pb-0 @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label mb-0 fw-medium text-darkgreen">{{ __('Password') }}</label>
                    <input id="password" type="password"
                        class="form-control text-darkgreen bg-sage rounded-0 border-0 border-bottom border-2 border-darkgreen pb-0 @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (Route::has('password.request'))
                        <a class="small fst-italic ms-auto text-darkgreen" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>


                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-darkgreen" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-darkgreen w-100">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="text-center mt-3 small">
                    <span class=" text-darkgreen">{{ __("Don't have an account?") }}</span>
                    <a class=" text-darkgreen" href="{{ route('register') }}">
                        {{ __('Register here') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
