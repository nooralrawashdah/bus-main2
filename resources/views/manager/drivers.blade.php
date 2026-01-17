@extends('layouts.manager')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Driver Management</h1>
            <p class="text-muted mb-0">Manage driver profiles and bus assignments</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-opacity-25 bg-success text-success border-0 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">{{ session('error') }}</div>
    @endif


    <div class="row">
        <!-- Driver List -->
        <div class="col-md-8">
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">Registered Drivers</h4>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>License #</th>
                                <th>Assigned Bus</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($drivers as $driver)
                                <tr>
                                    <td><span class="text-white">#{{ $driver->id }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div
                                                style="width: 32px; height: 32px; background: rgba(255,255,255,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                                👤
                                            </div>
                                            <strong>{{ $driver->user->name ?? 'N/A' }}</strong>
                                        </div>
                                    </td>
                                    <td class="text-white">{{ $driver->user->email ?? 'N/A' }}</td>
                                    <td><code
                                            style="color:var(--secondary-color);">{{ $driver->driver_license_number }}</code>
                                    </td>
                                    <td>
                                        @if ($driver->bus)
                                            <span class="badge badge-soft-success">
                                                🚌 {{ $driver->bus->plate_number }}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-warning">No Bus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('manager.drivers.edit', $driver->id) }}"
                                                class="btn btn-sm btn-outline-primary">Edit</a>

                                            <form action="{{ route('manager.drivers.delete', $driver->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to remove this driver? This creates a permanent deletion of the user account.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No drivers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Driver Form -->
        <div class="col-md-4">
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">Add New Driver</h4>
                <form method="POST" action="{{ route('manager.drivers.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Name</span>
                            <input type="text" class="form-control ps-3" name="name" required placeholder="John Doe">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Email</span>
                            <input type="email" class="form-control ps-3" name="email" required
                                placeholder="driver@example.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Phone</span>
                            <input type="text" class="form-control ps-3" name="phone_number" required
                                placeholder="079...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Password</span>
                            <input type="password" class="form-control ps-3" name="password" required
                                placeholder="********">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">License Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">License</span>
                            <input type="text" class="form-control ps-3" name="driver_license_number" required
                                placeholder="LIC-12345">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Assign Bus (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Bus</span>
                            <select class="form-select ps-3" name="bus_id">
                                <option value="">-- No Bus Assignment --</option>
                                @foreach ($availableBuses as $bus)
                                    <option value="{{ $bus->id }}">{{ $bus->plate_number }} (Cap:
                                        {{ $bus->capacity }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-premium w-100">Create Driver Account</button>
                </form>
            </div>
        </div>
    </div>
@endsection
