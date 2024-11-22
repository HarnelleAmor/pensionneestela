@extends('layouts.logreg')
@section('content')
    <div class="card rounded-4 border-0 col-lg-4 col-md-6 col-sm-8 mx-auto shadow-lg text-bg-sage">
        <div class="card-body px-5">
            <h4 class="text-center fw-semibold mt-2 text-darkgreen">Log In</h4>

            @if (session('status'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('deactivatedAccount'))
                <div class="alert alert-danger mb-4 rounded-4" role="alert">
                    <div class="d-flex justify-content-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                    </div>
                    <p class="mb-0 text-center small">
                        Your account is deactivated. To re-activate your account, reach out to us through <a href="mailto:pensionneestella@gmail.com">pensionneestella@gmail.com</a> or <a href="tel:470-944-7433">470-944-7433</a>.
                    </p>
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
