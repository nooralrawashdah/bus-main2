@extends('layouts.driver')
@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">Today's Trips</h2>
            <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm">&larr; Back</a>
        </div>

        {{-- عرض رسائل النجاح أو الخطأ --}}
        @if(session('success'))
            <div class="alert alert-success bg-opacity-25 bg-success text-success border-0 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">{{ session('error') }}</div>
        @endif
      {{--  هي هون بحال ما كان عند سائق ولا رحلة  --}}
        @if ($todayTrips->isEmpty())
            <div class="glass-card text-center py-5">
                <h4 class="text-muted">No trips scheduled for today.</h4>
            </div>
        @else
        {{-- هي هون اذا عندو رحلات  --}}
            <div class="row g-4">
                @foreach ($todayTrips as $trip)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card h-100 position-relative transition-hover">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="mb-0 text-white">Trip #{{ $trip->id }}</h4>
                                <span class="badge {{ $trip->status == 'STARTED' ? 'badge-soft-success' : ($trip->status == 'CANCELLED' ? 'badge-soft-danger' : 'badge-soft-warning') }}">
                                    {{ $trip->status }}
                                </span>
                            </div>

                            <p class="mb-1 text-white"><strong>Route:</strong> {{ $trip->route->route_name ?? 'N/A' }}</p>
                            <p class="mb-1 text-white"><strong>Start:</strong> {{ $trip->start_time }}</p>
                            <p class="mb-3 text-white"><strong>End:</strong> {{ $trip->end_time }}</p>

                            <div class="d-flex align-items-center justify-content-between mt-3 p-2 rounded"
                                 style="background: rgba(0,0,0,0.2);">
                                <span class="text-white fw-bold">Seats:</span>
                                <span class="text-white">{{ $trip->bookings_count ?? 0 }} / {{ $trip->bus->capacity ?? 'N/A' }}</span>
                            </div>
                            {{-- هي مشان بدء الرحلة  --}}
                            @php
                                $currentTime = \Carbon\Carbon::now()->format('H:i:s');
                                // فحص هل حان وقت الرحلة )
                                $isTimeToGo = $currentTime >= $trip->start_time;
                            @endphp

                            <div class="mt-4">
                                @if ($trip->status == 'SCHEDULED' || $trip->status == 'PENDING')
                                    @if ($isTimeToGo)
                                        {{-- الزر يظهر ويعمل لأن الوقت حان --}}
                                        <form method="POST" action="{{ route('driver.startTrip', $trip->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-premium w-100">Start Trip Now</button>
                                        </form>
                                    @else
                                        {{-- الزر يظهر لكنه معطل لأن الوقت لم يحن بعد --}}
                                        <button class="btn btn-secondary w-100" disabled>
                                            <i class="fas fa-clock me-2"></i> Waiting for Time
                                        </button>
                                        <small class="text-warning d-block text-center mt-2">Starts at {{ $trip->start_time }}</small>
                                    @endif

                                @elseif($trip->status == 'STARTED')
                                    <button class="btn btn-success w-100" disabled>
                                        <i class="fas fa-spinner fa-spin me-2"></i> Trip Started
                                    </button>

                                @elseif($trip->status == 'COMPLETED')
                                    <button class="btn btn-outline-light w-100" disabled>Trip Completed</button>
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
