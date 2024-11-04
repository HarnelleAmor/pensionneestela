@extends('layouts.manager')
@section('page', 'Notifications')
@section('content')
    <div class="container pt-3 vh-100">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col-lg-10 col-md-11">
                <livewire:manager-notifications />
            </div>
        </div>
    </div>
@endsection
