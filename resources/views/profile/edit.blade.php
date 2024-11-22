@extends(auth()->user()->usertype === 'manager' ? 'layouts.manager' : 'layouts.customer')
@if (auth()->user()->usertype == 'manager')
    @section('page', 'Profile')
@endif
@section('content')
    <div class="container mb-3 pt-2">
        <div class="row justify-content-center align-items-start g-4">
            <div class="col-12">
                @include('profile.partials.update-profile-information-form')
            </div>
            <div class="col-12">
                @include('profile.partials.update-password-form')
            </div>
            @if (auth()->user()->usertype === 'customer')
            <div class="col-12">
                @include('profile.partials.delete-user-form')
            </div>
            @endif
        </div>
    </div>
@endsection
