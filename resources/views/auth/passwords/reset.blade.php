@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="glass-login-card shadow-lg">
                <div class="text-center mb-4">
                    <i class="fas fa-user-shield fa-3x text-info mb-3"></i>
                    <h2 class="fw-bold text-white">New Password</h2>
                    <p class="text-secondary small">Set a strong password to secure your account</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label small text-white">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required readonly>
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-white">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••" autofocus>
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-white">Confirm New Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-info w-100 text-dark fw-bold py-2">
                        UPDATE PASSWORD
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
