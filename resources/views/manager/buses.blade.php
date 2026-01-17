@extends('layouts.manager')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Fleet Management</h1>
        <a href="{{ route('manager.buses.create') }}" class="btn btn-premium">
            + New Bus
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success bg-opacity-25 bg-success text-success border-0 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger bg-opacity-25 bg-danger text-danger border-0 mb-4">{{ session('error') }}</div>
    @endif

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Plate Number</th>
                        <th>Capacity</th>
                        <th>Driver Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buses as $bus)
                        <tr>
                            <td><span class="text-white">#{{ $bus->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 35px; height: 35px; border-radius: 8px; background: linear-gradient(135deg, #1e293b, #334155); display: flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 1.2rem;">
                                        🚌
                                    </div>
                                    <span style="font-weight: 600;">{{ $bus->plate_number }}</span>
                                </div>
                            </td>
                            <td>{{ $bus->capacity }} Seats</td>
                            <td>
                                @if ($bus->driver && $bus->driver->user)
                                    <span class="badge badge-soft-success">
                                        {{ $bus->driver->user->name }}
                                    </span>
                                @else
                                    <span class="badge badge-soft-warning">Unassigned</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('manager.buses.edit', $bus->id) }}"
                                    class="btn btn-sm btn-outline-primary me-2">Edit</a>

                                <form action="{{ route('manager.buses.delete', $bus->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-white">No buses found. Add your first bus!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
