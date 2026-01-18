<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bus Manager') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6366f1;
            /* Indigo 500 */
            --primary-hover: #4f46e5;
            /* Indigo 600 */
            --secondary-color: #ec4899;
            /* Pink 500 */
            --dark-bg: #0f172a;
            /* Slate 900 */
            --card-bg: rgba(30, 41, 59, 0.7);
            /* Slate 800 + Opacity */
            --text-main: #f8fafc;
            /* Slate 50 */
            --text-muted: #cbd5e1;
            /* Slate 300 */
            --border-color: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--dark-bg);
            /* Optional: Subtle gradient background */

        background: linear-gradient(rgba(15, 23, 42, 0.88), rgba(15, 23, 42, 0.88)),
          url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
            color: var(--text-main);
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: var(--text-muted) !important;
            transition: color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--text-main) !important;
        }

        /* Cards & Glassmorphism */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-main);
        }

        /* Buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.5);
            color: white;
        }

        /* Tables */
        .table-custom {
            width: 100%;
            margin-bottom: 0;
            color: var(--text-main);
        }

        .table-custom th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        /* Forms & Modals */
        .form-control,
        .form-select {
            background-color: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            border-radius: 8px;
            padding: 0.7rem;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(15, 23, 42, 0.8);
            border-color: var(--primary-color);
            color: var(--text-main);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .modal-content {
            background-color: #1e293b;
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .modal-header,
        .modal-footer {
            border-color: var(--border-color);
        }

        .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Badges */
        .badge-soft-success {
            background-color: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .badge-soft-warning {
            background-color: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    @php
    $pageName = request()->segment(2);
    $pageName = str_replace('-', '', $pageName);
@endphp
    <nav class="navbar navbar-expand-lg navbar-dark navbar-glass sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
             🚌 
                {{ucwords( $pageName)}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('manager.mdashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <div
                                style="width:35px; height:35px; background: linear-gradient(135deg, #6366f1, #a855f7); border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:bold; margin-right:8px;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark"
                            style="background:#1e293b; border:1px solid rgba(255,255,255,0.1);">
                            <li>
                                <h6 class="dropdown-header">Logged in as Admin</h6>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>

                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
