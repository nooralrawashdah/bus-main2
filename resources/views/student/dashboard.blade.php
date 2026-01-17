@extends('layouts.student')

@section('content')
    <div class="row align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="col-lg-10 text-center">
            <h1 class="display-4 fw-bold mb-5"
                style="background: linear-gradient(90deg, #f8fafc, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Welcome back, {{ Auth::user()->name }}
            </h1>

            <div class="row g-4 justify-content-center">
                <!-- Card 1: My Reservations -->
                <div class="col-md-4">
                    <a href="{{ route('student.reservations') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(99, 102, 241, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📑</div>
                            <h3 class="mb-0 text-white">My Reservations</h3>
                            <p class="text-white mt-2">View & Manage Bookings</p>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Available Trips -->
                <div class="col-md-4">
                    <a href="{{ route('student.trips') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(236, 72, 153, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🗓️</div>
                            <h3 class="mb-0 text-white">Available Trips</h3>
                            <p class="text-white mt-2">Browse & Book Trips</p>
                        </div>
                    </a>
                </div>

                <!-- Card 3: My Profile -->
                <div class="col-md-4">
                    <a href="{{ route('student.profile') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(245, 158, 11, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">👤</div>
                            <h3 class="mb-0 text-white">My Profile</h3>
                            <p class="text-white mt-2">Edit Info & Region</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
