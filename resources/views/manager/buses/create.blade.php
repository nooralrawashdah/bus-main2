@extends('layouts.manager')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="page-header">
                <h1 class="page-title">Add New Bus</h1>
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

                <form method="POST" action="{{ route('manager.buses.store') }}">
                    @csrf

                    <div class="alert alert-info bg-opacity-10 border-0 text-info small mb-4">
                        <i class="me-1">ℹ️</i> Enter the bus details. You can assign an available driver now or later.
                    </div>

                    {{-- رقم اللوحة --}}
                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Plate Number</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Plate</span>
                            <input type="text" class="form-control ps-3" name="plate_number" required
                                placeholder="e.g. ABC 1234" value="{{ old('plate_number') }}">
                        </div>
                    </div>

                    {{-- السعة --}}
                    <div class="mb-4">
                        <label class="form-label text-white small text-uppercase fw-bold">Capacity</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-white"
                                style="min-width: 80px;">Capacity</span>
                            <input type="number" class="form-control ps-3" name="capacity" required min="10"
                                placeholder="e.g. 50" value="{{ old('capacity') }}">
                        </div>
                    </div>

                    {{-- السائق (تمت إزالته لتبسيط التدفق: يتم تعيين الباص من صفحة السائقين) --}}
                    {{-- <div class="mb-4"> ... </div> --}}

                    <button type="submit" class="btn btn-premium w-100 py-2">Create Bus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
