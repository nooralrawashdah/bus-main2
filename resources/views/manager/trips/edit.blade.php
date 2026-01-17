@extends('layouts.manager')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="page-header">
                <h1 class="page-title">Edit Trip #{{ $trip->id }}</h1>
                <a href="{{ route('manager.trips') }}" class="btn btn-outline-light">
                    ← Back to List
                </a>
            </div>

            <div class="glass-card">
                @if ($errors->any())
                    <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('manager.trips.update', $trip->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Route --}}
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Route</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Route</span>
                            <select class="form-select ps-3" name="route_id" required>
                                <option value="">-- Select Route --</option>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}"
                                        {{ old('route_id', $trip->route_id) == $route->id ? 'selected' : '' }}>
                                        {{ $route->route_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Bus --}}
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Bus</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Bus</span>
                            <select class="form-select ps-3" name="bus_id" required>
                                <option value="">-- Select Bus --</option>
                                @foreach ($buses as $bus)
                                    <option value="{{ $bus->id }}"
                                        {{ old('bus_id', $trip->bus_id) == $bus->id ? 'selected' : '' }}>
                                        {{ $bus->plate_number }} (Cap: {{ $bus->capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Start Time --}}
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Start Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Start</span>
                            <input type="time" class="form-control ps-3" name="start_time"
                                value="{{ old('start_time', \Carbon\Carbon::parse($trip->start_time)->format('H:i')) }}"
                                required>
                        </div>
                    </div>

                    {{-- End Time --}}
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">End Time</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">End</span>
                            <input type="time" class="form-control ps-3" name="end_time"
                                value="{{ old('end_time', \Carbon\Carbon::parse($trip->end_time)->format('H:i')) }}"
                                required>
                        </div>
                    </div>

                    {{-- Trip Date --}}
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Trip Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Date</span>
                            <input type="date" class="form-control ps-3" name="trip_date"
                                value="{{ old('trip_date', $trip->trip_date) }}" required>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Status</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Status</span>
                            <select class="form-select ps-3" name="status">
                                <option value="SCHEDULED"
                                    {{ old('status', $trip->status) == 'SCHEDULED' ? 'selected' : '' }}>Scheduled</option>
                                <option value="STARTED" {{ old('status', $trip->status) == 'STARTED' ? 'selected' : '' }}>
                                    Started</option>
                                <option value="COMPLETED"
                                    {{ old('status', $trip->status) == 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                                <option value="CANCELLED"
                                    {{ old('status', $trip->status) == 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-premium w-100 py-2">Update Trip</button>
                </form>
            </div>
        </div>
    </div>
@endsection
