@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7"> <div class="glass-login-card shadow-lg">
                <div class="text-center mb-4">
                    <div class="icon-circle mb-3 d-inline-block bg-info bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-user-plus fa-2x text-info"></i>
                    </div>
                    <h2 class="fw-bold text-white">Create Account</h2>
                    <p class="text-secondary small">Join our bus system and start your journey</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger bg-danger bg-opacity-25 border-danger text-white border-0 mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label small text-secondary">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label small text-secondary">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label small text-secondary">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label small text-secondary">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label small text-secondary">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required placeholder="07xxxxxxxx">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="student_number" class="form-label small text-secondary">Student ID</label>
                            <input type="text" class="form-control" id="student_number" name="student_number" value="{{ old('student_number') }}" required placeholder="202xxxxx">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="region_id" class="form-label small text-secondary">Select Your Region (Address)</label>
                        <select class="form-select form-control" id="region_id" name="region_id" required>
                            <option value="" selected disabled>Choose your address...</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-info w-100 text-dark fw-bold py-3 shadow-sm mb-3">
                        <i class="fas fa-check-circle me-2"></i> SIGN UP NOW
                    </button>

                    <div class="text-center">
                        <p class="small text-secondary">Already have an account?
                            <a href="{{ route('login') }}" class="text-info text-decoration-none fw-bold">Login here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* تحسين شكل الـ Select داخل التصميم الزجاجي */
    .form-select option {
        background-color: #1e293b;
        color: white;
    }
</style>
@endsection
