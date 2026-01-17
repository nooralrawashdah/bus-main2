@extends('layouts.student')

@section('content')
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">My Reservations</h2>
        </div>

        @if ($bookings->count() > 0)
            <div class="glass-card table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>Trip #</th>
                            <th>Route</th>
                            <th>Trip Date</th>
                            <th>Time</th>
                            <th>Seat</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->trip->id ?? 'N/A' }}</td>
                                <td>{{ $booking->trip->route->route_name ?? 'N/A' }}</td>
                                <td>{{ $booking->trip->trip_date ?? 'N/A' }}</td>
                                <td>{{ $booking->trip->start_time ?? 'N/A' }} - {{ $booking->trip->end_time ?? 'N/A' }}</td>
                                <td>
                                    @if ($booking->busSeat && $booking->busSeat->seat)
                                        <span class="badge bg-primary me-1">{{ $booking->busSeat->seat->seat_number }}</span>
                                    @else
                                        <span class="text-muted">No specific seat</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $booking->status == 'CONFIRMED' ? 'badge-soft-success' : ($booking->status == 'CANCELLED' ? 'badge-soft-danger' : 'badge-soft-warning') }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($booking->status != 'CANCELLED')
                                        <form action="{{ route('student.reservations.cancel', $booking->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to cancel this reservation?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="glass-card text-center py-5">
                <h4 class="text-muted">You have no reservations yet.</h4>
                <a href="{{ route('student.trips') }}" class="btn btn-premium mt-3">Browse Trips</a>
            </div>
        @endif
    </div>
@endsection
