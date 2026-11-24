<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pickleball Equipment Inventory')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --pickle-primary: #0f4c3a;
            --pickle-accent: #facc15;
            --pickle-light: #f3f7f5;
        }
        body {
            background-color: var(--pickle-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand-custom {
            font-weight: 700;
            color: #ffffff !important;
            letter-spacing: 0.5px;
        }
        .navbar-custom {
            background-color: var(--pickle-primary);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        .nav-link {
            color: #d1fae5 !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255,255,255,0.15);
        }
        .badge-pickle {
            background-color: var(--pickle-accent);
            color: #1f2937;
            font-weight: 700;
        }
        .footer-custom {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            padding: 1.25rem 0;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom d-flex align-items-center gap-2" href="{{ route('equipment.index') }}">
                <i class="bi bi-trophy-fill text-warning fs-4"></i>
                <span>Pickleball<span class="badge badge-pickle ms-2 fs-6">INVENTORY</span></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-dismiss="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}" href="{{ route('equipment.index') }}">
                            <i class="bi bi-box-seam me-1"></i> Equipment Records
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            <i class="bi bi-bar-chart-line me-1"></i> Reports & Analytics
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-3 text-light small">
                            <i class="bi bi-person-circle text-warning me-1"></i>
                            Logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->username }})
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light px-3 rounded-pill">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-sm btn-warning px-3 rounded-pill fw-bold" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container py-4">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                <strong>Notice:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container text-center small">
            <div>Pickleball Equipment Inventory Management System &bull; IT9aL Examination Project</div>
            <div class="text-muted mt-1">Laravel MVC Architecture &bull; Models: User, Equipment</div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>