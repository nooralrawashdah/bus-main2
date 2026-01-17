@extends('layouts.manager')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="page-header">
                <h1 class="page-title">Edit Driver: {{ $driver->user->name }}</h1>
                <a href="{{ route('manager.drivers') }}" class="btn btn-outline-light">
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

                <form method="POST" action="{{ route('manager.drivers.update', $driver->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Name</span>
                            <input type="text" class="form-control ps-3" name="name"
                                value="{{ old('name', $driver->user->name) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Email</span>
                            <input type="email" class="form-control ps-3" name="email"
                                value="{{ old('email', $driver->user->email) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Phone</span>
                            <input type="text" class="form-control ps-3" name="phone_number"
                                value="{{ old('phone_number', $driver->user->phone_number) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">License Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">License</span>
                            <input type="text" class="form-control ps-3" name="driver_license_number"
                                value="{{ old('driver_license_number', $driver->driver_license_number) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Assigned Bus</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Bus</span>
                            <select class="form-select ps-3" name="bus_id">
                                <option value="">-- No Bus Assigned --</option>
                                @foreach ($availableBuses as $bus)
                                    <option value="{{ $bus->id }}"
                                        {{ optional($driver->bus)->id == $bus->id ? 'selected' : '' }}>
                                        {{ $bus->plate_number }} (Cap: {{ $bus->capacity }})
                                    </option>
                                @endforeach
                                {{-- Check if driver has a bus that is NOT in availableBuses (because it's assigned to him) --}}
                                @if ($driver->bus)
                                    <option value="{{ $driver->bus->id }}" selected>
                                        {{ $driver->bus->plate_number }} (Current)
                                    </option>
                                @endif
                            </select>
                        </div>
                        <small class="text-white mt-1 d-block">Select a bus to assign/reassign. Leave empty to remove
                            assignment.</small>
                    </div>

                    <button type="submit" class="btn btn-premium w-100 py-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
