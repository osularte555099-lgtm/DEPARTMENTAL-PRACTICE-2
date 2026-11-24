<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pickleball Equipment Inventory</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d3b2e 0%, #175e47 50%, #208b65 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            overflow: hidden;
            background: #ffffff;
        }
        .brand-header {
            background: #0f4c3a;
            color: #d1fae5;
            padding: 2.2rem 2rem;
            text-align: center;
        }
        .pickleball-badge {
            background-color: #facc15;
            color: #1f2937;
            font-weight: 700;
            padding: 0.35rem 0.85rem;
            border-radius: 50rem;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .btn-brand {
            background-color: #0f4c3a;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }
        .btn-brand:hover {
            background-color: #16654e;
            color: #ffffff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="brand-header">
                    <span class="pickleball-badge"><i class="bi bi-circle-fill text-warning me-1"></i> Inventory System</span>
                    <h3 class="fw-bold mb-1 text-white">Pickleball Admin</h3>
                    <p class="small text-white-50 mb-0">Equipment Inventory Management</p>
                </div>

                <div class="card-body p-4">
                    {{-- Flash notification for logout or errors --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show small" role="alert">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger small mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <!-- Email or Username Field -->
                        <div class="mb-3">
                            <label for="login" class="form-label fw-semibold text-secondary small">Email or Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" 
                                       name="login" 
                                       id="login" 
                                       class="form-control @error('login') is-invalid @enderror" 
                                       value="{{ old('login') }}" 
                                       placeholder="admin or admin@pickleball.test" 
                                       required 
                                       autofocus>
                            </div>
                            @error('login')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" 
                                       required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small text-muted" for="remember">
                                Remember this session
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-brand w-100 shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Dashboard
                        </button>
                    </form>

                    <!-- Demo Credentials Helper Card -->
                    <div class="mt-4 p-3 bg-light rounded-3 border small">
                        <div class="fw-bold text-dark mb-1"><i class="bi bi-info-circle text-primary me-1"></i> Demo Credentials:</div>
                        <div class="text-muted">Username: <code class="text-dark">admin</code></div>
                        <div class="text-muted">Email: <code class="text-dark">admin@pickleball.test</code></div>
                        <div class="text-muted">Password: <code class="text-dark">admin123</code></div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3 text-white-50 small">
                &copy; {{ date('Y') }} Pickleball Inventory System &bull; IT9aL
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>