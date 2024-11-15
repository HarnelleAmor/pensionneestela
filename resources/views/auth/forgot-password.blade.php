<x-guest-layout>
    @section('content')
        <div class="container pt-2" style="margin-top: 110px">
            <div class="card col-lg-6 col-md-6 rounded-3 mx-auto">
                <div class="card-body">
                    <p class="card-text fw-medium">
                        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 text-center col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="email" placeholder=""
                                    required autofocus />
                                @error('email')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-darkgreen">
                                {{ __('Email Password Reset Link') }}
                            </button>
                        </div>

                        @if (session('status'))
                            <div class="d-flex mt-3">
                                <div class="alert alert-info" role="alert">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

        </div>
    @endsection
</x-guest-layout>
