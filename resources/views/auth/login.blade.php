
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Login - {{ $settings->institution_name ?? 'Sistem Informasi DPRD' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ $settings->institution_name ?? 'Sistem Informasi DPRD' }}" name="description" />
    <!-- App favicon -->
    @if(isset($settings->favicon) && $settings->favicon)
        <link rel="shortcut icon" href="{{ asset('storage/' . $settings->favicon) }}">
    @else
        <link rel="shortcut icon" href="{{ asset('assets/admin/images/favicon.ico') }}">
    @endif

    <script src="{{ asset('assets/admin/js/layout.js') }}"></script>
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    
    <style>
        .alert-modern {
            border: none;
            border-radius: 8px;
            padding: 12px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .alert-modern .btn-close {
            padding: 0.5rem;
            opacity: 0.5;
        }
        
        .alert-modern .btn-close:hover {
            opacity: 1;
        }
        
        .alert-danger.alert-modern {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 4px solid #c53030;
        }
        
        .alert-success.alert-modern {
            background-color: #f0fdf4;
            color: #15803d;
            border-left: 4px solid #15803d;
        }
        
        .alert-modern i {
            flex-shrink: 0;
        }
    </style>

</head>

<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7">
                        <div class="card overflow-hidden">
                            <div class="card-body p-lg-5 p-4">
                                <!-- Logo -->
                                <div class="text-center mb-4">
                                    <a href="{{ route('home') }}" class="d-block">
                                        @if(isset($settings->logo) && $settings->logo)
                                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ $settings->institution_name ?? 'DPRD' }}" style="max-height: 80px; max-width: 250px; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('assets/admin/images/logo-light.png') }}" alt="DPRD" height="40">
                                        @endif
                                    </a>
                                </div>

                                <!-- Welcome Text -->
                                <div class="text-center mb-4">
                                    <h5 class="text-primary">Selamat Datang!</h5>
                                    <p class="text-muted">Silakan login untuk mengakses Admin Panel {{ $settings->institution_name ?? 'DPRD' }}.</p>
                                </div>

                                <!-- Alerts -->
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show alert-modern" role="alert">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-error-warning-line fs-20 me-2"></i>
                                            <div class="flex-grow-1">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show alert-modern" role="alert">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-error-warning-line fs-20 me-2"></i>
                                            <div class="flex-grow-1">{{ session('error') }}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show alert-modern" role="alert">
                                        <div class="d-flex align-items-start">
                                            <i class="ri-checkbox-circle-line fs-20 me-2"></i>
                                            <div class="flex-grow-1">{{ session('success') }}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif

                                <!-- Login Form -->
                                <form method="POST" action="{{ route('login') }}">
                                                @csrf

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input 
                                            type="text" 
                                            class="form-control @error('username') is-invalid @enderror" 
                                            id="username" 
                                            name="username" 
                                            value="{{ old('username') }}" 
                                            placeholder="Masukkan username"
                                            required 
                                            autofocus
                                        >
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input 
                                                type="password" 
                                                class="form-control pe-5 password-input @error('password') is-invalid @enderror" 
                                                placeholder="Masukkan password" 
                                                id="password-input"
                                                name="password"
                                                required
                                            >
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon">
                                                <i class="ri-eye-fill align-middle"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" id="auth-remember-check" name="remember">
                                        <label class="form-check-label" for="auth-remember-check">Ingat saya</label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">
                                            <i class="ri-login-box-line me-1"></i> Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> {{ $settings->institution_name ?? 'Sistem Informasi DPRD' }}. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pages/password-addon.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-modern');
            
            alerts.forEach(function(alert) {
                // Auto hide after 5 seconds
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>

</html>