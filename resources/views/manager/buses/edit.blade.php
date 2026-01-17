@extends('layouts.manager')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="page-header">
                <h1 class="page-title">Edit Bus #{{ $bus->id }}</h1>
                <a href="{{ route('manager.buses') }}" class="btn btn-outline-light">
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

                <form method="POST" action="{{ route('manager.buses.update', $bus->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Plate Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Plate</span>
                            <input type="text" class="form-control ps-3" name="plate_number"
                                value="{{ old('plate_number', $bus->plate_number) }}" required>
                        </div>
                    </div>

                    {{-- Driver assignment is handled via Driver Management --}}
                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Capacity</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Capacity</span>
                            <input type="number" class="form-control ps-3" name="capacity"
                                value="{{ old('capacity', $bus->capacity) }}" required min="10">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-premium w-100 py-2">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
