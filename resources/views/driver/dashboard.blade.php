@extends('layouts.driver')
@section('content')
    <div class="row align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="col-lg-8 text-center">
            <h1 class="display-4 fw-bold mb-5"
                style="background: linear-gradient(90deg, #f8fafc, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Welcome back, {{ Auth::user()->name }}
            </h1>

            <div class="row g-4 justify-content-center">
                <!-- Today's Trips -->
                <div class="col-md-6">
                    <a href="{{ route('driver.trips') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(99, 102, 241, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                            <h3 class="mb-0 text-white">Today's Trips</h3>
                            <p class="text-white mt-2">Check your schedule</p>
                        </div>
                    </a>
                </div>

                <!-- My Bus -->
                <div class="col-md-6">
                    <a href="{{ route('driver.bus') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(16, 185, 129, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🚌</div>
                            <h3 class="mb-0 text-white">My Bus</h3>
                            <p class="text-white mt-2">Vehicle Details</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
