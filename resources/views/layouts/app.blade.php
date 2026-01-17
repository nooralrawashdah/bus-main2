<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bus System</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        /* صورة خلفية فخمة مع طبقة تظليل أغمق قليلاً لتوضيح النصوص */
        background: linear-gradient(rgba(10, 15, 30, 0.85), rgba(10, 15, 30, 0.85)),
                    url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=2069');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #ffffff; /* أبيض صريح للنصوص */
        min-height: 100vh;
        font-family: 'Nunito', sans-serif;
    }

    /* بوكس تسجيل الدخول والتسجيل الزجاجي */
    .glass-login-card {
        background: rgba(255, 255, 255, 0.08); /* زيادة الشفافية قليلاً */
        backdrop-filter: blur(25px); /* زيادة التغبيش لخلفية البوكس */

        /* إضافة بوردر أبيض خفيف جداً وناعم */
        border: 1px solid rgba(255, 255, 255, 0.15);

        border-radius: 25px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        padding: 40px;
        color: #ffffff;
    }

    /* جعل العناوين والـ Labels ناصعة البياض */
    h2, h3, h4, .form-label, .text-white {
        color: #ffffff !important;
        text-shadow: 0px 2px 4px rgba(0,0,0,0.5); /* إضافة ظل خفيف للنص لزيادة الوضوح */
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important; /* نص الكتابة أبيض */
    }

    /* النصوص الثانوية (مثل "Don't have an account?") */
    .text-secondary {
        color: rgba(255, 255, 255, 0.7) !important;
    }
</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <i class="fas fa-bus text-info me-2 fs-3"></i>
                    <span class="fw-bold tracking-wider">BUS <span class="text-info">SYSTEM</span></span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item ms-md-2">
                                    <a class="nav-link btn btn-outline-info btn-auth text-info" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="bg-info rounded-circle d-inline-block me-2 text-center" style="width: 30px; height: 30px; line-height: 30px;">
                                        <i class="fas fa-user text-dark small"></i>
                                    </div>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2 text-danger"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
