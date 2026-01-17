@extends('layouts.manager')

@section('content')
    <div class="row align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="col-lg-8 text-center">
            <h1 class="display-4 fw-bold mb-5"
                style="background: linear-gradient(90deg, #f8fafc, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Welcome back, {{ Auth::user()->name }}
            </h1>

            <div class="row g-4">
                <!-- Routes -->
                <div class="col-md-6">
                    <a href="{{ route('manager.routes') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(99, 102, 241, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🛣️</div>
                            <h3 class="mb-0 text-white">Manage Routes</h3>
                            <p class="text-white mt-2">Create & Edit Trip Paths</p>
                        </div>
                    </a>
                </div>

                <!-- Buses -->
                <div class="col-md-6">
                    <a href="{{ route('manager.buses') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(236, 72, 153, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🚌</div>
                            <h3 class="mb-0 text-white">Manage Buses</h3>
                            <p class="text-white mt-2">Fleet & Assignments</p>
                        </div>
                    </a>
                </div>

                <!-- Trips -->
                <div class="col-md-6">
                    <a href="{{ route('manager.trips') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(245, 158, 11, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                            <h3 class="mb-0 text-white">Manage Trips</h3>
                            <p class="text-white mt-2">Schedule & Status</p>
                        </div>
                    </a>
                </div>

                <!-- Drivers -->
                <div class="col-md-6">
                    <a href="{{ route('manager.drivers') }}" class="text-decoration-none">
                        <div class="glass-card h-100 d-flex flex-column align-items-center justify-content-center py-5 transition-hover"
                            style="border:1px solid rgba(16, 185, 129, 0.3);">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">👨‍✈️</div>
                            <h3 class="mb-0 text-white">Manage Drivers</h3>
                            <p class="text-white mt-2">Profiles & Licenses</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            background: rgba(30, 41, 59, 0.9);
        }
    </style>
@endsection
