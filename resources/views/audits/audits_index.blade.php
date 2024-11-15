@extends('layouts.manager')
@section('page', 'Audit Logs')
@section('content')
    <div class="container py-3">
        <div class="row justify-content-center align-items-center g-2">
            <div class="col">
                <livewire:audits>
            </div>
        </div>
    </div>
@endsection
