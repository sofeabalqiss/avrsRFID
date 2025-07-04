<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AVRS Admin - Automated Visitor Registration System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/489/489941.png">

    <!-- Vite Resources -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Admin Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin/dashboard') }}">

                <span class="fw-bold">AVRS Admin</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <!-- Admin Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="{{ url('/admin/dashboard') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/admins') }}" class="nav-link {{ request()->is('admin/admins') ? 'active' : '' }}">
                            <i class="fas fa-user-shield me-1"></i> Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/guards') }}" class="nav-link {{ request()->is('admin/guards') ? 'active' : '' }}">
                            <i class="fas fa-user-tie me-1"></i> Guards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/visitor-logs') }}" class="nav-link {{ request()->is('admin/visitor-logs') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list me-1"></i> Visitor Logs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/admin/rfid-cards') }}" class="nav-link {{ request()->is('admin/rfid-cards') ? 'active' : '' }}">
                            <i class="fas fa-id-card me-1"></i> RFID Cards
                        </a>
                    </li>
                </ul>

                <!-- Admin User Menu -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-sm me-2">
                                <span class="avatar-title bg-light text-primary rounded-circle">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="me-1">{{ Auth::user()->name }}</span>
                            <small class="badge bg-light text-primary ms-1">Admin</small>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">@yield('title')</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
                        @yield('breadcrumbs')
                    </ol>
                </nav>
            </div>

            <!-- Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-3">AVRS Admin</h5>
                    <p>Automated Visitor Registration System Administration Panel</p>
                    <p class="small text-muted mb-0">© 2025 Sofea Balqis. All rights reserved.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ url('/admin/dashboard') }}" class="nav-link p-0 text-white-50">Dashboard</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('/admin/visitor-logs') }}" class="nav-link p-0 text-white-50">Visitor Logs</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ url('/admin/rfid-cards') }}" class="nav-link p-0 text-white-50">RFID Management</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Contact Developer</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> 010-9414342</li>
                        <li class="mb-2"><i class="fab fa-instagram me-2"></i> s.feabalqis</li>
                        <li class="mb-2"><i class="fab fa-linkedin me-2"></i> Sofea Balqis Mohamad Ali</li>
                        <li><i class="fas fa-graduation-cap me-2"></i> Bachelor of Computer Science (Hons) Netcentric Computing</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>
</html>
