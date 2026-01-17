@extends('layouts.driver')
@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">Today's Trips</h2>
            <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm">&larr; Back</a>
        </div>

        @if ($todayTrips->isEmpty())
            <div class="glass-card text-center py-5">
                <h4 class="text-muted">No trips scheduled for today.</h4>
            </div>
        @else
            <div class="row g-4">
                @foreach ($todayTrips as $trip)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card h-100 position-relative transition-hover">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="mb-0 text-white">Trip #{{ $trip->id }}</h4>
                                <span
                                    class="badge {{ $trip->status == 'STARTED' ? 'badge-soft-success' : ($trip->status == 'CANCELLED' ? 'badge-soft-danger' : 'badge-soft-warning') }}">
                                    {{ $trip->status }}
                                </span>
                            </div>

                            <p class="mb-1"><strong>Route:</strong> {{ $trip->route->route_name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Start:</strong> {{ $trip->start_time }}</p>
                            <p class="mb-3"><strong>End:</strong> {{ $trip->end_time }}</p>

                            <div class="d-flex align-items-center justify-content-between mt-3 p-2 rounded"
                                style="background: rgba(0,0,0,0.2);">
                                <span class="text-white fw-bold">Seats:</span>
                                <span class="text-white">{{ $trip->bookings_count ?? 0 }} /
                                    {{ $trip->bus->capacity ?? 'N/A' }}</span>
                            </div>

                            <!-- Action Button -->
                            @if ($trip->status == 'PENDING')
                                <form method="POST" action="{{ route('driver.startTrip', $trip->id) }}" class="mt-4">
                                    @csrf
                                    <button type="submit" class="btn btn-premium w-100">Start Trip</button>
                                </form>
                            @elseif($trip->status == 'STARTED')
                                <button class="btn btn-success w-100 mt-4" disabled>In Progress</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
