@extends('layouts.customer')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <h3 class="card-title text-center">Available Units</h3>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="alert alert-info text-center">
                    <strong>Selected Dates:</strong> {{ $show_in }} - {{ $show_out }}
                </div>
            </div>
        </div>
        @foreach ($units_with_status as $unit)
            <div
                class="alert alert-{{ $unit->is_available ? 'success' : 'secondary' }} d-flex justify-content-between align-items-center">
                <span>{{ $unit->name }} is {{ $unit->is_available ? 'available' : 'not available' }} now</span>
                @if ($unit->is_available)
                    <form action="{{ route('unit.selected') }}" method="post" class="mb-0">
                        @csrf
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                        <input type="hidden" name="checkin" value="{{ $unit->checkin_date }}">
                        <input type="hidden" name="checkout" value="{{ $unit->checkout_date }}">
                        <button type="submit" class="btn btn-primary btn-sm">Book Now</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection