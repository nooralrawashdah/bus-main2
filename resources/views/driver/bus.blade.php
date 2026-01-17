@extends('layouts.driver')
@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">

        <div class="col-md-8 col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-white">Bus Information</h2>
                <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm">&larr; Back</a>
            </div>

            @if ($assignedBus)
                <div class="glass-card text-center p-5 transition-hover">
                    <div style="font-size: 5rem; margin-bottom: 1.5rem;">🚌</div>

                    <h3 class="text-white mb-4">Bus #{{ $assignedBus->id }}</h3>

                    <div class="d-flex justify-content-between border-bottom border-light pb-2 mb-3">
                        <span class="text-muted">Plate Number:</span>
                        <span class="fw-bold text-white">{{ $assignedBus->plate_number }}</span>
                    </div>

                    <div class="d-flex justify-content-between border-bottom border-light pb-2 mb-3">
                        <span class="text-muted">Capacity:</span>
                        <span class="fw-bold text-white">{{ $assignedBus->capacity }} Seats</span>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <span class="text-muted">Status:</span>
                        <span class="badge badge-soft-success">Active</span>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('driver.trips') }}" class="btn btn-premium w-100">View Trips</a>
                    </div>
                </div>
            @else
                <div class="glass-card text-center p-5">
                    <h4 class="text-white">No bus assigned to you yet.</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
