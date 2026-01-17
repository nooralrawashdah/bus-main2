@extends('layouts.student')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">
                Select a Bus
                <small class="text-muted fs-6 d-block d-md-inline ms-md-2">for Trip #{{ $trip->id }} to
                    {{ $trip->route->end_point }}</small>
            </h2>
            <a href="{{ route('student.trips') }}" class="btn btn-outline-light">
                &larr; Back
            </a>
        </div>

        @if ($buses->isEmpty())
            <div class="glass-card text-center py-5">
                <h4 class="text-muted">No buses available for this trip yet.</h4>
            </div>
        @else
            <div class="row g-4">
                @foreach ($buses as $bus)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card h-100 position-relative transition-hover text-center">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🚌</div>
                            <h5 class="card-title text-white mb-1">{{ $bus->plate_number }}</h5>
                            <!-- Assuming 'plate_number' is the correct field, unrelated code used 'name'/'number' which might be wrong based on Bus model -->
                            <p class="text-muted mb-4">Bus #{{ $bus->id }}</p>

                            <div class="d-flex justify-content-around mb-4 p-2 rounded"
                                style="background: rgba(0,0,0,0.2);">
                                <div>
                                    <small class="d-block text-muted">Capacity</small>
                                    <strong class="text-white">{{ $bus->capacity }}</strong>
                                </div>
                                <div>
                                    <small class="d-block text-muted">Reserved</small>
                                    <strong class="text-white">{{ $bus->reserved_seats ?? 0 }}</strong>
                                </div>
                                <div>
                                    <small class="d-block text-muted">Available</small>
                                    <strong class="text-success">{{ $bus->capacity - ($bus->reserved_seats ?? 0) }}</strong>
                                </div>
                            </div>

                            <a href="{{ route('student.seats', ['trip' => $trip->id, 'bus' => $bus->id]) }}"
                                class="btn btn-premium w-100">
                                Select Seats
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
