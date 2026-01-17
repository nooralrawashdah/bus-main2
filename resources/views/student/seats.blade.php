@extends('layouts.student')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">
                Select Seat
                <small class="text-muted fs-6 d-block d-md-inline ms-md-2">Bus #{{ $bus->id }}</small>
            </h2>
            <a href="{{ route('student.buses', $trip->id) }}" class="btn btn-outline-light">
                &larr; Back
            </a>
        </div>

        <div class="glass-card p-4">
            <div class="d-flex justify-content-center mb-5 gap-4">
                <div class="d-flex align-items-center">
                    <div class="rounded border me-2"
                        style="width: 20px; height: 20px; background-color: transparent; border-color: #10b981 !important;">
                    </div>
                    <span class="text-white">Available</span>
                </div>
                <div class="d-flex align-items-center">
                    <div class="rounded border me-2"
                        style="width: 20px; height: 20px; background-color: #ef4444; border-color: #ef4444 !important;">
                    </div>
                    <span class="text-white">Booked</span>
                </div>
            </div>

            <div class="row row-cols-4 row-cols-md-6 g-3 text-center justify-content-center">
                @foreach ($seats as $seat)
                    @php
                        // Check if seat is booked for this trip
                        $isBooked = $seat->bookings->contains('trip_id', $trip->id);
                    @endphp

                    <div class="col">
                        @if ($isBooked)
                            <button class="btn w-100 disabled"
                                style="background-color: #ef4444; border: 1px solid #ef4444; color: white; opacity: 0.5; cursor: not-allowed;"
                                disabled>
                                {{ $seat->seat->seat_number }}
                            </button>
                        @else
                            <form action="{{ route('student.reserve', ['trip' => $trip->id, 'seat' => $seat->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn w-100 btn-outline-light"
                                    style="border-color: rgba(255,255,255,0.3);"
                                    onmouseover="this.style.borderColor='#10b981'; this.style.color='#10b981';"
                                    onmouseout="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.color='white';"
                                    onclick="return confirm('Confirm booking details for seat {{ $seat->seat_number }}?')">
                                    {{ $seat->seat->seat_number }}
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
