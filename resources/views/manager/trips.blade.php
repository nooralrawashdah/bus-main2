@extends('layouts.manager')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Trip Management</h1>
            <p class="text-white mb-0">Schedule and monitor bus trips</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-opacity-25 bg-success text-success border-0 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Trips List -->
        <div class="col-md-8">
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">Scheduled Trips</h4>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Route</th>
                                <th>Bus</th>
                                <th>Schedule</th>
                                <th>Status</th>
                                <th>Trip Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trips as $trip)
                                <tr>
                                    <td><span class="text-white">#{{ $trip->id }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">🛣️</span>
                                            <strong>{{ $trip->route->route_name ?? 'N/A' }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trip->bus)
                                            <span class="badge badge-soft-success">🚌 {{ $trip->bus->plate_number }}</span>
                                        @else
                                            <span class="badge badge-soft-warning">No Bus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-white">
                                            <div>Start: {{ $trip->start_time }}</div>
                                            <div>End: {{ $trip->end_time }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trip->status == 'SCHEDULED')
                                            <span class="badge badge-soft-primary">Scheduled</span>
                                        @elseif($trip->status == 'CANCELLED')
                                            <span class="badge badge-soft-danger">Cancelled</span>
                                        @elseif($trip->status == 'COMPLETED')
                                            <span class="badge badge-soft-success">Completed</span>
                                        @else
                                            <span class="badge badge-soft-light">{{ $trip->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small text-white">
                                            {{ \Carbon\Carbon::parse($trip->trip_date)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('manager.trips.edit', $trip->id) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('manager.trips.delete', $trip->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this trip?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-white py-4">No trips scheduled.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Trip Form -->
        <div class="col-md-4">
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">Schedule New Trip</h4>
                <form method="POST" action="{{ route('manager.trips.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Route</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Route</span>
                            <select class="form-select ps-3" name="route_id" required>
                                <option value="">-- Select Route --</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}">{{ $route->route_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- عرض باصات الموجودة -->
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Bus</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Bus</span>
                            <select class="form-select ps-3" name="bus_id" required>
                                <option value="">-- Select Bus --</option>
                                @foreach ($buses as $bus)
                                    <option value="{{ $bus->id }}">{{ $bus->plate_number }} (Cap:
                                        {{ $bus->capacity }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Start Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Start</span>
                            <input type="time" class="form-control ps-3" name="start_time" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">End Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">End</span>
                            <input type="time" class="form-control ps-3" name="end_time" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Status</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Status</span>
                            <select class="form-select ps-3" name="status">
                                <option value="SCHEDULED">Scheduled</option>
                                <option value="CANCELLED">Cancelled</option>
                                <option value="COMPLETED">Completed</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label text-white small text-uppercase fw-bold">trip-date</label>
                            <input type="date" class="form-control ps-3" name="trip_date" required>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-premium w-100">Schedule Trip</button>
                </form>
            </div>
        </div>
    </div>
@endsection
