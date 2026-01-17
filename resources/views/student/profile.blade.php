@extends('layouts.student')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="page-header justify-content-center">
                <h2 class="page-title">My Profile</h2>
            </div>

            <div class="glass-card">

                <div class="text-center mb-4">
                    <div
                        style="width:80px; height:80px; background: linear-gradient(135deg, #6366f1, #a855f7); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size: 2rem; font-weight:bold; margin: 0 auto;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <h4 class="mt-3 text-white">{{ Auth::user()->name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-white">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-white">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control"
                            value="{{ Auth::user()->phone_number }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white">Region</label>
                        <select name="region_id" class="form-select">
                            <option value="">Select Region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}"
                                    {{ Auth::user()->region_id == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-premium btn-lg">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
