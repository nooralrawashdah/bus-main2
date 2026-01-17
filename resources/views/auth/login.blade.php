@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="glass-login-card">
                <div class="text-center mb-4">
                    <i class="fas fa-bus-alt fa-3x text-info mb-3"></i>
                    <h2 class="fw-bold text-white">Welcome Back</h2>
                    <p class="text-secondary">Please enter your details</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small text-white">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-white">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- الإضافة هنا: توزيع تذكرني ونسيان كلمة المرور في سطر واحد --}}
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check mb-0">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small text-white" for="remember">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-info text-decoration-none small fw-bold" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-info w-100 text-dark fw-bold mb-3">
                        LOGIN
                    </button>

                    <div class="text-center mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                        <p class="small text-secondary mb-0">Don't have an account?</p>
                        <a href="{{ route('register') }}" class="text-info text-decoration-none fw-bold">Create an account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
