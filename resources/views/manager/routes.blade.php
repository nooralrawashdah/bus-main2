@extends('layouts.manager')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Route Management</h1>
            <p class="text-white mb-0">Define and manage bus routes</p>
        </div>
    </div>

    {{-- رسائل التنبيه --}}
    @if (session('success'))
        <div class="alert alert-success bg-opacity-25 bg-success text-success border-0 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-9"> {{-- زدت العرض قليلاً ليناسب الأعمدة الإضافية --}}
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">Available Routes</h4>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Route Name</th>
                                <th>Start Point</th>
                                <th>End Point</th>
                                <th>Region</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($routes as $route)
                                <tr>
                                    <td><span class="text-white-50">#{{ $route->id }}</span></td>
                                    <td><strong class="text-white">{{ $route->route_name }}</strong></td>
                                    <td><span class="text-white small">{{ $route->start_point }}</span></td>
                                    <td><span class="text-white small">{{ $route->end_point }}</span></td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-25 text-info border border-info border-opacity-25">
                                            {{ $route->region->region_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('manager.routes.delete', $route->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this route?')"
                                                    style="border-radius: 8px; padding: 5px 12px;">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-white py-4 italic">No routes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="glass-card">
                <h4 class="mb-4" style="color:var(--text-main);">New Route</h4>
                <form method="POST" action="{{ route('manager.routes.create') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Route Name</label>
                        <input type="text" class="form-control @error('route_name') is-invalid @enderror"
                               name="route_name" value="{{ old('route_name') }}" required placeholder="Name">
                        @error('route_name')
                            <div class="text-danger small mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">Start Point</label>
                        <input type="text" class="form-control" name="start_point" value="{{ old('start_point') }}" required placeholder="Start">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white small text-uppercase fw-bold">End Point</label>
                        <input type="text" class="form-control" name="end_point" value="{{ old('end_point') }}" required placeholder="End">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Region</label>
                        <select class="form-control form-select" name="region_id" required>
                            <option value="" class="bg-dark">Select</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" class="bg-dark text-white" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-premium w-100">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
