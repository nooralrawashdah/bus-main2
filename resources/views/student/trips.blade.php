@extends('layouts.student')

@section('content')
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Available Trips</h2>
        </div>

        @if (isset($trips) && $trips->count() > 0) {{-- isset  هي مشان اذا في قيمة ولا ما في قيمة --}}
            <div class="row g-4">
                @foreach ($trips as $trip)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card h-100 position-relative transition-hover">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h4 class="mb-0 text-white">Trip #{{ $trip->id }}</h4>
                                <span
                                    class="badge {{ $trip->status == 'STARTED' ? 'badge-soft-success' : 'badge-soft-warning' }}">
                                    {{ $trip->status }}
                                </span>
                            </div>

                            <p class="mb-1"><strong>Route:</strong> {{ $trip->route->route_name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>From:</strong> {{ $trip->route->start_point ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>To:</strong> {{ $trip->route->end_point ?? 'N/A' }}</p>
                            <hr style="border-color: rgba(255,255,255,0.1)">
                            <p class="mb-1"><strong>Date:</strong> {{ $trip->trip_date }}</p>
                            <p class="mb-1"><strong>Start:</strong> {{ $trip->start_time }}</p>

                            <div class="mt-4">
                                @if ($trip->status === 'STARTED')
                                    {{-- زر أخضر Disabled --}}
                                    <button class="btn btn-success w-100" disabled>
                                        Trip Started
                                    </button>
                                @else
                                    {{-- زر الحجز العادي --}}
                                    <a href="{{ route('student.buses', $trip->id) }}" class="btn btn-premium w-100">
                                        View Buses & Book
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-card text-center py-5">
                <h4 class="text-muted">No available trips at the moment.</h4>
            </div>
        @endif
    </div>
@endsection
